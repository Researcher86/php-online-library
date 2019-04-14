@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="{!! url('/'); !!}">Главная</a> / {!! createLinksForGenres($book->getGenres()); !!} / {{ $book->title  }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <img class="card-img-top" src="{!! url($book->getPrimaryImage()); !!}" alt="{{ $book->title }}">
            </div>
            <div class="col-md-9">
                <h3>{{ $book->title }}</h3>
                <h5>Автор: {{ $book->getAuthorsNames() }}</h5>
                <h5>Жанр: {{ $book->getGenresNames() }}</h5>
                <rating :id="{{ $book->id }}" :rating="{{ $book->calculateRatingAverage() }}"></rating>
                <p>
                    {{ $book->annotation }}
                </p>
            </div>
        </div>
    </div>
@endsection