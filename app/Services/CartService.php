<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'cart';

    public function getCart()
    {
        if (Auth::check()) {
            return CartItem::with('game')
                ->where('user_id', Auth::id())
                ->get();
        }

        // для гостей — сессия
        $items = Session::get($this->sessionKey, []);

        return collect($items)->map(function ($item) {
            $game = Game::find($item['game_id']);
            if (!$game) return null;
            return (object) [
                'id'       => $item['id'] ?? null,
                'game'     => $game,
                'quantity' => $item['quantity'],
                'price'    => $game->current_price,
                'subtotal' => $item['quantity'] * $game->current_price,
            ];
        })->filter()->values();
    }

    public function add(Game $game, $quantity = 1)
    {
        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'game_id' => $game->id,
            ]);

            $item->quantity += $quantity;
            $item->price = $game->current_price; // фиксируем цену
            $item->save();

            return $item;
        }

        // гость — сессия
        $cart = Session::get($this->sessionKey, []);
        $key = array_search($game->id, array_column($cart, 'game_id'));

        if ($key !== false) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[] = [
                'game_id'  => $game->id,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);
        return true;
    }

    public function updateQuantity($gameId, $quantity)
    {
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())
                ->where('game_id', $gameId)
                ->first();

            if ($item) {
                if ($quantity <= 0) {
                    $item->delete();
                } else {
                    $item->quantity = $quantity;
                    $item->save();
                }
            }
            return;
        }

        $cart = Session::get($this->sessionKey, []);
        $key = array_search($gameId, array_column($cart, 'game_id'));

        if ($key !== false) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $quantity;
            }
            Session::put($this->sessionKey, array_values($cart));
        }
    }

    public function remove($gameId)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('game_id', $gameId)
                ->delete();
            return;
        }

        $cart = Session::get($this->sessionKey, []);
        $cart = array_filter($cart, fn($item) => $item['game_id'] != $gameId);
        Session::put($this->sessionKey, array_values($cart));
    }

    public function clear()
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        }
        Session::forget($this->sessionKey);
    }

    public function count()
    {
        return $this->getCart()->sum('quantity');
    }

    public function total()
    {
        return $this->getCart()->sum('subtotal');
    }

    // При логине переносим сессионную корзину в БД
    public function mergeAfterLogin()
    {
        if (!Auth::check()) return;

        $sessionCart = Session::get($this->sessionKey, []);
        foreach ($sessionCart as $item) {
            $this->add(Game::find($item['game_id']), $item['quantity']);
        }
        Session::forget($this->sessionKey);
    }
}
