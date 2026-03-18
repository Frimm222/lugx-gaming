<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(): View
    {
        $users = User::query()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $userData = $user; // Переименовываем для теста

        return view('admin.users.edit', ['userData' => $userData]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name'       => ['required', 'string', 'max:255'],
                'nickname'   => ['nullable', 'string', 'max:50', 'unique:users,nickname,' . $user->id],
                'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'birth_date' => ['nullable', 'date', 'before:-13 years'],
                'country'    => ['nullable', 'string', 'size:2'],
                'city'       => ['nullable', 'string', 'max:100'],
                'phone'      => ['nullable', 'string', 'max:20'],
                'balance'    => ['numeric', 'min:0'],
                'is_verified' => ['boolean'],
                'receives_newsletter' => ['boolean'],
                'avatar'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            ]);

            $oldAvatar = $user->avatar;

            DB::transaction(function () use ($request, $user, $validated, &$path) {
                // Обработка загрузки аватарки
                if ($request->hasFile('avatar')) {
                    $path = $request->file('avatar')->store('avatars', 'public');
                    $validated['avatar'] = $path;
                }

                // Обновляем только разрешённые поля
                $user->update($validated);
            });

            // После успешного коммита удаляем старый аватар, если был загружен новый
            if ($request->hasFile('avatar') && $oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }

            Log::info('Пользователь успешно обновлён', ['user_id' => $user->id, 'updated_by' => auth()->id()]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Пользователь успешно обновлён');

        } catch (\Exception $e) {
            // Если новый аватар был загружен, но транзакция не удалась - удаляем его
            if ($request->hasFile('avatar') && isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error('Ошибка при обновлении пользователя: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'data' => $request->except(['_token', '_method']),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при обновлении пользователя. Пожалуйста, попробуйте снова.');
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Нельзя удалить самого себя');
        }

        try {
            // При мягком удалении транзакция не обязательна,
            // но можно оставить для консистентности
            DB::beginTransaction();

            $userAvatar = $user->avatar;

            // Мягкое удаление пользователя
            $user->delete();

            DB::commit();

            // Удаляем аватар (физически) после мягкого удаления
            if ($userAvatar && Storage::disk('public')->exists($userAvatar)) {
                Storage::disk('public')->delete($userAvatar);
            }

            Log::info('Пользователь мягко удалён', ['user_id' => $user->id, 'deleted_by' => auth()->id()]);

            return back()->with('success', 'Пользователь перемещён в корзину');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Ошибка при мягком удалении пользователя: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Произошла ошибка при удалении пользователя.');
        }
    }
    public function restore($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return back()->with('success', 'Пользователь восстановлен');
    }

    public function forceDelete($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        // Здесь уже нужно будет обрабатывать связанные записи
        // так как это физическое удаление

        $user->forceDelete();

        return back()->with('success', 'Пользователь полностью удалён');
    }
}
