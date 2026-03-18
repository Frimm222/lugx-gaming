@extends('layouts.admin')

@section('title', 'Редактировать игру: ' . $game->title)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-4 mb-4">Редактировать игру: {{ $game->title }}</h1>

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
                        <h5 class="mb-0">Редактирование игры</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.games.update', $game) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Основная информация (аналогично create) -->
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="title" class="form-label fw-bold">Название игры *</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', $game->title) }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="slug" class="form-label fw-bold">Slug (URL) *</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                                           value="{{ old('slug', $game->slug) }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="game_id_code" class="form-label fw-bold">Game ID / Код игры</label>
                                    <input type="text" name="game_id_code" id="game_id_code" class="form-control"
                                           value="{{ old('game_id_code', $game->game_id_code) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="release_date" class="form-label fw-bold">Дата выхода</label>
                                    <input type="date" name="release_date" id="release_date" class="form-control"
                                           value="{{ old('release_date', $game->release_date) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="developer" class="form-label fw-bold">Разработчик</label>
                                    <input type="text" name="developer" id="developer" class="form-control"
                                           value="{{ old('developer', $game->developer) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="publisher" class="form-label fw-bold">Издатель</label>
                                    <input type="text" name="publisher" id="publisher" class="form-control"
                                           value="{{ old('publisher', $game->publisher) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="developer" class="form-label fw-bold">Цена</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           value="{{ old('price', $game->price) }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="publisher" class="form-label fw-bold">Цена со скидкой</label>
                                    <input type="text" name="discount_price" id="discount_price" class="form-control"
                                           value="{{ old('discount_price', $game->discount_price) }}">
                                </div>

                                <div class="mt-4">
                                    <label for="short_description" class="form-label fw-bold">Короткое описание</label>
                                    <textarea name="short_description" id="short_description" rows="3" class="form-control">{{ old('short_description', $game->short_description) }}</textarea>
                                </div>

                                <div class="mt-3">
                                    <label for="description" class="form-label fw-bold">Полное описание</label>
                                    <textarea name="description" id="description" rows="8" class="form-control">{{ old('description', $game->description) }}</textarea>
                                </div>

                                <!-- Обложка с текущим изображением -->
                                <div class="col-md-4">
                                    <label for="cover_image" class="form-label fw-bold">Обложка игры</label>
                                    @if($game->cover_image)
                                        <div class="mb-2">
                                            <img src="{{ asset($game->cover_image) }}" alt="Текущая обложка" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                    @endif
                                    <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror"
                                           accept="image/*">
                                    @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Жанры, платформы, теги (с выбранными) -->
                            <div class="row g-4 mt-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Жанры</label>
                                    <select name="genres[]" multiple class="form-select" size="8">
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->id }}"
                                                {{ $game->genres->contains($genre->id) ? 'selected' : '' }}>
                                                {{ $genre->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Платформы</label>
                                    <select name="platforms[]" multiple class="form-select" size="8">
                                        @foreach($platforms as $platform)
                                            <option value="{{ $platform->id }}"
                                                {{ $game->platforms->contains($platform->id) ? 'selected' : '' }}>
                                                {{ $platform->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Теги</label>
                                    <select name="tags[]" multiple class="form-select" size="8">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ $game->tags->contains($tag->id) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Сохранить изменения</button>
                                <a href="{{ route('admin.games.index') }}" class="btn btn-outline-secondary btn-lg px-5">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
