<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        $games = Game::withCount('reviews')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.games.index', compact('games'));
    }

    public function create(): View
    {
        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();
        $tags      = Tag::orderBy('name')->get();

        return view('admin.games.create', compact('genres', 'platforms', 'tags'));
    }

    public function store(GameRequest $request): RedirectResponse
    {
        try {
            $game = DB::transaction(function () use ($request) {
                $data = $request->validated();

                if ($request->hasFile('cover_image')) {
                    $data['cover_image'] = $request->file('cover_image')->store('games/covers', 'public');
                }

                $game = Game::create($data);

                $game->genres()->sync($request->input('genres', []));
                $game->platforms()->sync($request->input('platforms', []));
                $game->tags()->sync($request->input('tags', []));

                return $game;
            });

            return redirect()->route('admin.games.index')
                ->with('success', 'Игра добавлена');

        } catch (\Exception $e) {
            Log::error('Ошибка при создании игры: ' . $e->getMessage(), [
                'data' => $request->validated(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при создании игры. Пожалуйста, попробуйте снова.');
        }
    }

    public function edit(Game $game): View
    {
        $game->load(['genres', 'platforms', 'tags']);

        $genres    = Genre::orderBy('name')->get();
        $platforms = Platform::orderBy('name')->get();
        $tags      = Tag::orderBy('name')->get();

        return view('admin.games.edit', compact('game', 'genres', 'platforms', 'tags'));
    }

    public function update(GameRequest $request, Game $game): RedirectResponse
    {
        try {
            $oldCoverImage = $game->cover_image;

            DB::transaction(function () use ($request, $game, &$data) {
                $data = $request->validated();

                if ($request->hasFile('cover_image')) {
                    $data['cover_image'] = $request->file('cover_image')->store('games/covers', 'public');
                }

                $game->update($data);

                $game->genres()->sync($request->input('genres', []));
                $game->platforms()->sync($request->input('platforms', []));
                $game->tags()->sync($request->input('tags', []));
            });

            // После успешного коммита удаляем старую обложку, если была загружена новая
            if ($request->hasFile('cover_image') && $oldCoverImage && Storage::disk('public')->exists($oldCoverImage)) {
                Storage::disk('public')->delete($oldCoverImage);
            }

            return redirect()->route('admin.games.index')
                ->with('success', 'Игра обновлена');

        } catch (\Exception $e) {
            // Если новый файл был загружен, но транзакция не удалась - удаляем его
            if ($request->hasFile('cover_image')) {
                $newCoverPath = 'games/covers/' . $request->file('cover_image')->hashName();
                if (Storage::disk('public')->exists($newCoverPath)) {
                    Storage::disk('public')->delete($newCoverPath);
                }
            }

            Log::error('Ошибка при обновлении игры: ' . $e->getMessage(), [
                'game_id' => $game->id,
                'data' => $request->validated(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Произошла ошибка при обновлении игры. Пожалуйста, попробуйте снова.');
        }
    }

    public function destroy(Game $game): RedirectResponse
    {
        $game->delete();

        return back()->with('success', 'Игра удалена');
    }
}
