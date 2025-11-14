<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookRepository implements BookRepositoryInterface
{

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Book::with('author')->paginate($perPage);
    }

    public function find(int $id): ?Book
    {
        return Book::with('author')->find($id);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(Book $book, array $data): Book
    {
        $book->update($data);
        return $book->fresh('author');
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }
}
