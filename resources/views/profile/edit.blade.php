@extends('layouts.main')

@section('title', 'Редактировать профиль')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Редактирование профиля</h3>
                    <span class="breadcrumb"><a href="{{route('home')}}">Home</a>  >  Редактирование профиля</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-secondary text-white text-center py-4">
                        <h3 class="mb-0">Редактирование профиля</h3>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Аватар -->
                            <div class="text-center mb-5">
                                <img src="{{ $user->profile_photo_url }}"
                                     alt="Аватар"
                                     class="rounded-circle mb-3 shadow"
                                     style="width: 120px; height: 120px; object-fit: cover;">

                                <div class="mt-3">
                                    <label for="avatar" class="btn btn-outline-primary">
                                        <i class="bi bi-camera-fill me-2"></i>Изменить фото
                                    </label>
                                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
                                    @error('avatar')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold">Имя / Ник в игре</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nickname" class="form-label fw-bold">Никнейм (отображается публично)</label>
                                    <input type="text" name="nickname" id="nickname" class="form-control @error('nickname') is-invalid @enderror"
                                           value="{{ old('nickname', $user->nickname) }}">
                                    @error('nickname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label fw-bold">Страна</label>
                                    <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror"
                                           value="{{ old('country', $user->country) }}" maxlength="2" placeholder="UA">
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="city" class="form-label fw-bold">Город</label>
                                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city', $user->city) }}">
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label fw-bold">Дата рождения</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror"
                                           value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                                    @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4">
                                    <hr>
                                    <h6 class="mb-3">Смена пароля (оставьте пустым, если не хотите менять)</h6>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">Новый пароль</label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">Повторите пароль</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Сохранить изменения
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Предпросмотр аватарки
        document.getElementById('avatar')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('img.rounded-circle').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
