<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $query = Game::query()->orderByDesc("release_date")->with(['genres']);
        $trendingGames = $query->paginate(4);
        $query = Game::query()->orderByDesc("views_count")->with(['genres']);
        $mostPopularGames = $query->paginate(6);

        return view('index', compact(["trendingGames", "mostPopularGames"]));
    }
}
