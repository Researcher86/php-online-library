@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Главная</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <h5>Жанры</h5>
                <hr class="mt-0 mb-4">
                @foreach($genres as $genre)
                    <div>
                        <a href="{!! url('/books/genres', $genre->id); !!}">{{ $genre->name }}</a>
                    </div>
                @endforeach
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-9 text-right">
                                <h5>Сортировка: </h5>
                            </div>
                            <div class="col-3 mt-xl-n1">
                                <select class="custom-select custom-select-sm mb-0" id="inputGroupSelect01">
                                    <option value="1">Популярные</option>
                                    <option value="2">Новинки</option>
                                    <option value="3">Высокий рейтинг</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mt-0 mb-4">
                    </div>
                </div>
                <div class="row book-list">
                    @foreach($books as $book)
                        <div class="col-3 mb-4">
                            <div class="card">
                                <a href="{!! url('/books', $book->id) !!}">
                                    <img data-toggle="tooltip" data-placement="top" class="card-img-top" src="{!! url($book->getPrimaryImage()); !!}" title="{{ $book->title }}">
                                </a>
                                <div class="card-body">
                                    <rating class="mb-2" :id="{{ $book->id }}" :rating="{{ $book->calculateRatingAverage() }}"></rating>
                                    <div class="row mb-2">
                                        <div class="col-9">
                                            <i class="far fa-eye"> 12456456</i>
                                        </div>
                                        <div class="col-2">

                                        </div>
                                    </div>
                                    <a href="{!! url('/books', $book->id) !!}" class="card-text">{{ $book->title }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        {{ $books->links('components/pagination-default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection