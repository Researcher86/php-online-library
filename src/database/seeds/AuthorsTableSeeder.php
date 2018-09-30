<?php

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    public function run()
    {
        $authors = [
            'Пауло Коэльо',
            'Дарья Донцова',
            'Джоан Роулинг',
            'Чайлд Ли',
            'Татьяна Устинова',
            'Эрих Мария Ремарк',
            'Владимир Набоков',
            'Памела Трэверс',
            'Тестовый автор',
            'Михаил Юрьевич Лермонтов',
            'Пушкин Александр Сергеевич',
            'Борис Акунин',
            'Теофиль Готье',
            'Дэвид Вайз',
            'Джефри Янг',
            'Чарльз Диккенс',
            'Николай Лесков',
            'Новый автор',
            'Еще автор',
            'Александр Романович',
            'Алла Лагутина'
        ];

        foreach ($authors as $author) {
            Author::create(['name' => $author]);
        }
    }
}