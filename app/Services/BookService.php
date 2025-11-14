<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    public function __construct(
        protected BookRepositoryInterface $booksRepository
    ) {}

    public function list(int $perPage = 10): LengthAwarePaginator
    {
        return $this->booksRepository->paginate($perPage);
    }

    public function findOrFail(int $id): Book
    {
        $book = $this->booksRepository->find($id);
        abort_if(!$book, 404, 'Book not found');
        return $book;
    }

    public function create(array $data): Book
    {
        return $this->booksRepository->create($data);
    }

    public function update(int $id, array $data): Book
    {
        $book = $this->findOrFail($id);
        return $this->booksRepository->update($book, $data);
    }

    public function delete(int $id): void
    {
        $book = $this->findOrFail($id);
        $this->booksRepository->delete($book);
    }
}
