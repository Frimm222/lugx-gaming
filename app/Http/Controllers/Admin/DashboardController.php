<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'games_count'   => Game::count(),
            'users_count'   => User::count(),
            'orders_count'  => Order::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total'),
        ];

        $latest_games = Game::latest()->take(5)->get();
        $latest_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_games', 'latest_users'));
    }
}
