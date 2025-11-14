<?php

namespace App\Repositories\Interfaces;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): ?Book;
    public function create(array $data): Book;
    public function update(Book $book, array $data): Book;
    public function delete(Book $book): void;
}
