<?php

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenresTableSeeder extends Seeder
{
    public function run()
    {
        $genres = [
            'Детектив',
            'Мистика',
            'Юмор',
            'Исторический',
            'Роман',
            'Сказка',
            'Приключения',
            'Бизнес',
            'Боевик',
            'Религия',
            'Компьютеры',
            'Семья',
            'Психология',
            'Биография',
            'Вестерн',
            'Драма',
            'Фэнтези',
            'Мемуары',
            'Рассказ',
            'Пьеса',
            'Новый жанр',
            'Научная фантастика',
            'Современные детективы',
        ];

        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}