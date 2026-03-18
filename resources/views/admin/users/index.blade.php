@extends('layouts.admin')

@section('title', 'Пользователи')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4 mb-4">Управление пользователями</h1>

        <div class="card shadow border-0">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Список пользователей</h5>
            </div>

            <div class="card-body">
                @if($users->isEmpty())
                    <div class="alert alert-info text-center py-5">
                        Пользователей пока нет
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Никнейм</th>
                                <th>Баланс</th>
                                <th>Дата регистрации</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->nickname ?? '—' }}</td>
                                    <td>{{ number_format($user->balance, 2, ',', ' ') }} $</td>
                                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="btn btn-sm btn-primary">Редактировать</a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Удалить пользователя {{ $user->name }}?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
