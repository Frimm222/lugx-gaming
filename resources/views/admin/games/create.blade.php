@extends('layouts.admin')

@section('title', 'Добавить новую игру')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-4 mb-4">Добавить новую игру</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Новая игра</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.games.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Основная информация -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="title" class="form-label fw-bold">Название игры *</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title') }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="slug" class="form-label fw-bold">Slug (URL) *</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug') }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="game_id_code" class="form-label fw-bold">Game ID / Код игры</label>
                                    <input type="text" name="game_id_code" id="game_id_code" class="form-control"
                                           value="{{ old('game_id_code') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="release_date" class="form-label fw-bold">Дата выхода</label>
                                    <input type="date" name="release_date" id="release_date" class="form-control"
                                           value="{{ old('release_date') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="developer" class="form-label fw-bold">Разработчик</label>
                                    <input type="text" name="developer" id="developer" class="form-control"
                                           value="{{ old('developer') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="publisher" class="form-label fw-bold">Издатель</label>
                                    <input type="text" name="publisher" id="publisher" class="form-control"
                                           value="{{ old('publisher') }}">
                                </div>
                            </div>

                            <!-- Цены -->
                            <div class="row g-4 mt-2">
                                <div class="col-md-4">
                                    <label for="price" class="form-label fw-bold">Цена *</label>
                                    <input type="number" name="price" id="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price') }}" required>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="discount_price" class="form-label fw-bold">Цена со скидкой</label>
                                    <input type="number" name="discount_price" id="discount_price" step="0.01" class="form-control"
                                           value="{{ old('discount_price') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="cover_image" class="form-label fw-bold">Обложка игры</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror"
                                           accept="image/*">
                                    @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Рекомендуемый размер: 460×215 px</small>
                                </div>
                            </div>

                            <!-- Описания -->
                            <div class="mt-4">
                                <label for="short_description" class="form-label fw-bold">Короткое описание</label>
                                <textarea name="short_description" id="short_description" rows="3" class="form-control">
                                {{ old('short_description') }}
                            </textarea>
                            </div>

                            <div class="mt-3">
                                <label for="description" class="form-label fw-bold">Полное описание</label>
                                <textarea name="description" id="description" rows="8" class="form-control">
                                {{ old('description') }}
                            </textarea>
                            </div>

                            <!-- Жанры, платформы, теги -->
                            <div class="row g-4 mt-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Жанры</label>
                                    <select name="genres[]" multiple class="form-select" size="8">
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Зажмите Ctrl для выбора нескольких</small>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Платформы</label>
                                    <select name="platforms[]" multiple class="form-select" size="8">
                                        @foreach($platforms as $platform)
                                            <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Теги</label>
                                    <select name="tags[]" multiple class="form-select" size="8">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Сохранить игру</button>
                                <a href="{{ route('admin.games.index') }}" class="btn btn-outline-secondary btn-lg px-5">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
