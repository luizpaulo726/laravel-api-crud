<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Author::query()->paginate($perPage);
    }

    public function find(int $id): ?Author
    {
        return Author::find($id);
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function update(Author $author, array $data): Author
    {
        $author->update($data);
        return $author;
    }

    public function delete(Author $author): void
    {
        $author->delete();
    }
}
