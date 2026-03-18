@extends('layouts.admin')

@section('title', 'Редактировать пользователя')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(!$userData)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Ошибка!</strong> Пользователь с ID {{ request()->id ?? '—' }} не найден или был удалён.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <p class="mt-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                                Вернуться к списку пользователей
                            </a>
                        </p>
                    </div>
                @else
                    <h1 class="mt-4 mb-4">
                        Редактировать пользователя: {{ $userData->display_name ?? $userData->name ?? 'Без имени' }}
                        <small class="text-muted d-block fs-6">
                            ID: {{ $userData->id }} | Email: {{ $userData->email }} |
                            Возраст: {{ $userData->age ?? 'не указан' }}
                        </small>
                    </h1>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Ошибка валидации!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Форма редактирования</h5>
                        </div>

                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('admin.users.update', $userData) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <!-- Аватар -->
                                    <div class="col-md-4 text-center">
                                        <label class="form-label fw-bold d-block">Аватар</label>
                                        @if (isset($userData->avatar))
                                        <img src="{{ asset('storage/'. $userData->avatar) }}" alt="Аватар"
                                             class="rounded-circle mb-3 shadow"
                                             style="width: 140px; height: 140px; object-fit: cover;">
                                        @endif
                                        <input type="file" name="avatar" id="avatar"
                                               class="form-control @error('avatar') is-invalid @enderror"
                                               accept="image/*">
                                        @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Основные поля -->
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label fw-bold">Имя *</label>
                                                <input type="text" name="name" id="name"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       value="{{ old('name', $userData->name) }}" required>
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="nickname" class="form-label fw-bold">Никнейм</label>
                                                <input type="text" name="nickname" id="nickname"
                                                       class="form-control @error('nickname') is-invalid @enderror"
                                                       value="{{ old('nickname', $userData->nickname) }}">
                                                @error('nickname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="email" class="form-label fw-bold">Email *</label>
                                                <input type="email" name="email" id="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       value="{{ old('email', $userData->email) }}" required>
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="balance" class="form-label fw-bold">Баланс ($)</label>
                                                <input type="number" name="balance" id="balance" step="0.01" min="0"
                                                       class="form-control @error('balance') is-invalid @enderror"
                                                       value="{{ old('balance', $userData->balance) }}">
                                                @error('balance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="birth_date" class="form-label fw-bold">Дата рождения</label>
                                                <input type="date" name="birth_date" id="birth_date"
                                                       class="form-control @error('birth_date') is-invalid @enderror"
                                                       value="{{ old('birth_date', $userData->birth_date?->format('Y-m-d')) }}">
                                                @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label for="country" class="form-label fw-bold">Страна</label>
                                                <input type="text" name="country" id="country" maxlength="2"
                                                       class="form-control @error('country') is-invalid @enderror"
                                                       value="{{ old('country', $userData->country) }}">
                                                @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-3">
                                                <label for="city" class="form-label fw-bold">Город</label>
                                                <input type="text" name="city" id="city"
                                                       class="form-control @error('city') is-invalid @enderror"
                                                       value="{{ old('city', $userData->city) }}">
                                                @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Примечание о пароле -->
                                    <div class="col-12 mt-4">
                                        <div class="alert alert-info small mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Пароль не меняется через эту форму. Для сброса используйте восстановление
                                            или базу данных.
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопки -->
                                <div class="mt-5 d-flex gap-3 flex-wrap">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-save me-2"></i> Сохранить
                                    </button>

                                    <a href="{{ route('admin.users.index') }}"
                                       class="btn btn-outline-secondary btn-lg px-5">
                                        <i class="bi bi-arrow-left me-2"></i> Назад
                                    </a>
                                </div>
                            </form>
                            @if($userData->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $userData) }}" method="POST"
                                      class="d-inline ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-lg px-5"
                                            onclick="return confirm('Удалить {{ $userData->display_name ?? $userData->name }}?')">
                                        <i class="bi bi-trash me-2"></i> Удалить
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
