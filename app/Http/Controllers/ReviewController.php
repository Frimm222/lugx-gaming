<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Сохранить новый отзыв
     */
    public function store(ReviewStoreRequest $request, Game $game)
    {
        // Проверка: пользователь купил игру
        if (!$this->userHasPurchasedGame($game)) {
            return back()->with('error', 'Вы можете оставить отзыв только после покупки игры.');
        }

        // Проверка: уже есть отзыв
        if ($game->hasReviewBy(Auth::user())) {
            return back()->with('error', 'Вы уже оставляли отзыв на эту игру.');
        }

        Review::create([
            'game_id'      => $game->id,
            'user_id'      => Auth::id(),
            'rating'       => $request->rating,
            'title'        => $request->title,
            'comment'      => $request->comment,
            'is_verified'  => $this->userHasPurchasedGame($game), // если купил — верифицирован
            'is_published' => true,
        ]);

        return back()->with('success', 'Ваш отзыв успешно добавлен!');
    }

    /**
     * Обновить отзыв
     */
    public function update(ReviewUpdateRequest $request, Game $game, Review $review)
    {
        $this->authorizeReview($review);

        $review->update([
            'rating'  => $request->rating,
            'title'   => $request->title,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Отзыв обновлён.');
    }

    /**
     * Удалить отзыв
     */
    public function destroy(Game $game, Review $review)
    {
        $this->authorizeReview($review);

        $review->delete();

        return back()->with('success', 'Отзыв удалён.');
    }

    /**
     * Проверка, что отзыв принадлежит текущему пользователю
     */
    private function authorizeReview(Review $review): void
    {
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Вы не можете редактировать/удалять этот отзыв.');
        }
    }

    /**
     * Проверка, что пользователь купил игру
     */
    private function userHasPurchasedGame(Game $game): bool
    {
        return Auth::user()
            ->orders()
            ->whereHas('items', fn($q) => $q->where('game_id', $game->id))
            ->where('status', 'paid') // или другой статус успешной оплаты
            ->exists();
    }
}
