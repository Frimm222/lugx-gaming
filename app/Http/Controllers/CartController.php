<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Показать содержимое корзины
     */
    public function show()
    {
        $items = $this->cart->getCart();
        $total = $this->cart->total();

        return view('cart.show', compact('items', 'total'));
    }

    /**
     * Добавить игру в корзину
     */
    public function add(Request $request, Game $game)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $this->cart->add($game, $quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Игра добавлена в корзину',
                'count'   => $this->cart->count(),
                'total'   => number_format($this->cart->total(), 0, ',', ' ') . ' ₽',
            ]);
        }

        return redirect()->back()
            ->with('success', "{$game->title} добавлена в корзину");
    }

    /**
     * Обновить количество товара в корзине
     */
    public function update(Request $request, Game $game)
    {
        $quantity = (int) $request->input('quantity', 1);

        $this->cart->updateQuantity($game->id, $quantity);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => $this->cart->count(),
                'total'   => number_format($this->cart->total(), 0, ',', ' ') . ' ₽',
            ]);
        }

        return redirect()->route('cart.show')
            ->with('success', 'Количество обновлено');
    }

    /**
     * Удалить конкретный товар из корзины
     */
    public function remove(Game $game)
    {
        $this->cart->remove($game->id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => $this->cart->count(),
                'total'   => number_format($this->cart->total(), 0, ',', ' ') . ' ₽',
            ]);
        }

        return redirect()->route('cart.show')
            ->with('success', 'Товар удалён из корзины');
    }

    /**
     * Очистить всю корзину
     */
    public function clear()
    {
        $this->cart->clear();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'count'   => 0,
                'total'   => '0 ₽',
            ]);
        }

        return redirect()->route('cart.show')
            ->with('success', 'Корзина очищена');
    }

    /**
     * Получить текущее количество товаров (для хедера, AJAX)
     */
    public function count()
    {
        return response()->json([
            'count' => $this->cart->count(),
        ]);
    }
}
