<?php

namespace App\Services\Book\Index;

/**
 * Интерфейс для сервисов индексации информации о книгах
 * Interface IndexBookServiceInterface
 * @package App\Services\Book\Index
 */
interface IndexBookServiceInterface
{
    /**
     * Добавляет книгу в индекс, если книга уже есть в индексе, то обновляет
     * @param Request $request
     * @return bool
     */
    public function add(Request $request): bool;

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
     * Нечеткий поиск книги по заголовку
     * @param string $title
     * @return Response[]
     */
    public function searchByTitle(string $title);

    /**
     * Нечеткий поиск книги по автору
     * @param string $name
     * @return Response[]
     */
    public function searchByAuthor(string $name);

    /**
     * Нечеткий поиск книги по краткому содержанию
     * @param string $annotation
     * @return Response[]
     */
    public function searchByAnnotation(string $annotation);

    /**
     * Подсчет количества книг в индексе
     * @return int
     */
    public function count(): int;
}