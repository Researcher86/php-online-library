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
                            <a href="#">{{$genre->name}}</a> <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-9">

            </div>
        </div>
    </div>
@endsection
