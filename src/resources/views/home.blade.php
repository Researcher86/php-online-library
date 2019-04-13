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
                <div class="card">
                    <div class="card-header">Жанры</div>

                    <div class="card-body">
                        @foreach($genres as $genre)
                            <div>
                                <a href="{!! url('/books/genres', $genre->id); !!}">{{ $genre->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row book-list">
                    @foreach($books as $book)
                        <div class="col-3 mb-4">
                            <div class="card">
                                <img class="card-img-top" src="{!! url($book->getPrimaryImage()); !!}" alt="{{ $book->title }}">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $book->title }}</h6>
                                    {{--                                    <star-rating class="mb-3" v-bind:increment="0.5" v-bind:show-rating="false" v-bind:star-size="25" v-model="book.rating" @rating-selected="setRating($event, book)"></star-rating>--}}
                                    <i class="far fa-eye">12</i>
                                    <a href="#"><i class="fas fa-book-open"></i></a>
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