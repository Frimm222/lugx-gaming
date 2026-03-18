<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Показать страницу оформления заказа
     */
    public function index()
    {
        $items = $this->cart->getCart();
        $total = $this->cart->total();

        if ($items->isEmpty()) {
            return redirect()->route('cart.show')
                ->with('error', 'Ваша корзина пуста');
        }

        return view('checkout.index', compact('items', 'total'));
    }

    /**
     * Обработать заказ (создать заказ, симулировать оплату)
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,balance', // добавь свои методы
            'agree_terms'    => 'required|accepted',
        ]);

        $items = $this->cart->getCart();
        $total = $this->cart->total();

        if ($items->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Корзина пуста');
        }

        // Транзакция — чтобы ничего не сломалось
        return DB::transaction(function () use ($items, $total, $request) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'order_number'   => Order::generateOrderNumber(),
                'total'          => $total,
                'status'         => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id'  => $item->game->id,
                    'quantity' => $item->quantity,
                    'price'    => $item->price ?? $item->game->current_price,
                ]);
            }

            // Симуляция оплаты (здесь потом будет Stripe / YooKassa / etc.)
            // Например:
            // if ($request->payment_method === 'card') {
            //     $payment = $this->processStripePayment($order);
            //     if (!$payment['success']) {
            //         throw new \Exception('Оплата не прошла');
            //     }
            //     $order->update(['status' => 'paid', 'payment_data' => $payment]);
            // }

            // Для теста сразу считаем оплаченным
            $order->update(['status' => 'paid']);

            // Очищаем корзину
            $this->cart->clear();

            // Можно отправить email
            // Mail::to(Auth::user())->send(new OrderConfirmation($order));

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Заказ успешно оформлен!');
        });
    }

    /**
     * Страница успешного заказа
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items.game')
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
