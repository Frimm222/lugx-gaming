<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(Request $request): View
    {
        $query = Game::query()
            ->with(['genres', 'platforms'])
            ->when($request->search, fn($q) =>
            $q->where('title', 'like', '%' . trim($request->search) . '%')
            );

        $games = $query->paginate(10);
        $games->appends($request->query());

        return view('games.index', compact('games'));
    }

    public function show(Game $game): View
    {
        $game->increment('views_count');

        $game->load([
            'genres',
            'platforms',
            'tags',
            'reviews' => function ($query) {
                $query->published()           // ← scope применяется к запросу
                ->with('user');
            },
        ]);
        $averageRating = $game->reviews()->avg('rating');
        $related = Game::whereHas('genres', fn($q) => $q->whereIn('genres.id', $game->genres->pluck('id')))
            ->where('id', '!=', $game->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('games.show', compact('game', 'related', 'averageRating'));
    }

    public function addToCart(Request $request, Game $game)
    {
        $cart = app(CartService::class);
        $cart->add($game, $request->input('quantity', 1));

        return redirect()->back()->with('success', 'Игра добавлена в корзину!');
    }




}
