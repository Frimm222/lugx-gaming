<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = Auth::user()->load([
            'orders.items.game' => function ($query) {
                $query->select('id', 'title', 'slug', 'cover_image');
            }
        ]);

        return view('profile.show', compact('user'));
    }

    public function edit(): View
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        if ($request->filled('nickname') && $request->nickname !== $user->nickname) {
            $request->validate(['nickname' => 'unique:users,nickname']);
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Обработка аватарки
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('status', 'Профиль успешно обновлён');
    }
}
