@extends('layouts.admin')

@section('title', 'Управление играми')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Управление играми</h1>

        <a href="{{ route('admin.games.create') }}" class="btn btn-success mb-4">Добавить игру</a>

        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Обложка</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Скидка</th>
                        <th>Отзывы</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{ $game->id }}</td>
                            <td>
                                @if($game->cover_image)
                                    <img src="{{ asset('storage/' . $game->cover_image) }}" alt="" width="80">
                                @endif
                            </td>
                            <td>{{ $game->title }}</td>
                            <td>{{ $game->price }} $</td>
                            <td>{{ $game->discount_price ? $game->discount_price . ' $' : '-' }}</td>
                            <td>{{ $game->reviews_count }}</td>
                            <td>
                                <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm btn-primary">Редактировать</a>
                                <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить игру?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $games->links() }}
            </div>
        </div>
    </div>
@endsection
