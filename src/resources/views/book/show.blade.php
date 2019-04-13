@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="{!! url('/'); !!}">Главная</a> / {{ $book->title  }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-3">
                <img class="card-img-top" src="{!! url($book->getPrimaryImage()); !!}" alt="{{ $book->title }}">
            </div>

            <div class="col-md-9">
                <h3>{{ $book->title }}</h3>
                <h5>Authors: {{ $book->getAuthors() }}</h5>
                <p>
                    {{ $book->annotation }}
                </p>
            </div>
        </div>
    </div>
@endsection