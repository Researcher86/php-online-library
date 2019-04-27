<?php

namespace App\Services\Book\Index;

use App\Models\Book\Book;

/**
 * Интерфейс для сервисов индексации информации о книгах
 * Interface IndexBookServiceInterface
 * @package App\Services\Book\Index
 */
interface IndexBookServiceInterface
{
    /**
     * Добавляет книгу в индекс, если книга уже есть в индексе, то обновляет
     * @param Book $book
     * @return bool
     */
    public function add(Book $book): bool;

    /**
     * Удаляет книгу из индекса
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Пересоздания структуры индекса
     */
    public function restore(): void;

    /**
     * Нечеткий поиск по книге
     * @param string $text
     * @param int $page
     * @param int $limit
     * @return Response
     */
    public function search(string $text, int $page, int $limit): Response;

    /**
     * Подсчет количества книг в индексе
     * @return int
     */
    public function count(): int;
}