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
                        <a href="{!! url('/books/genres', $genre->id) !!}">{{ $genre->name }}</a>
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

                 <h4>Найдено: {{ $total }}</h4>

                <div class="row book-list mt-3">
                    @foreach($books as $book)
                        <div class="col-md-3">
                            <a href="{!! url('/books', $book->id) !!}">
                                <img class="card-img-top" src="{!! url($book->getPrimaryImage()) !!}" alt="{{ $book->title }}">
                            </a>
                        </div>
                        <div class="col-md-9">
                            <a href="{!! url('/books', $book->id) !!}" class="card-text"><h3>{{ $book->title }}</h3></a>
                            <b>Автор: </b><span>{{ $book->getAuthorsNames() }}</span>
                            <br>
                            <b>Жанр: </b><span>{{ $book->getGenresNames() }}</span>
                            <br>
                            <rating :id="{{ $book->id }}" :rating="{{ $book->calculateRatingAverage() }}"></rating>
                            <br>
                            <p>
                                {{ $book->annotation }}
                            </p>
                        </div>
                        <hr class="mt-0 mb-4 w-100">
                    @endforeach
                    <div class="col-12">
                        {{ $books->links('components/pagination-default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection