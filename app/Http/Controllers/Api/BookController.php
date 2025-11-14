<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;
use App\Services\AuthorService;

class BookController extends Controller
{

    public function __construct(
        protected BookService $booksService,
    ) {}

    /**
     * @OA\Get(
     *     path="/books",
     *     summary="Listar livros",
     *     tags={"Books"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Quantidade por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de livros"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return response()->json($this->booksService->list($perPage));
    }

    /**
     * @OA\Post(
     *     path="/books",
     *     summary="Criar livro",
     *     tags={"Books"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"author_id","title"},
     *             @OA\Property(
     *                 property="author_id",
     *                 type="integer",
     *                 example=1,
     *                 description="ID do autor (deve existir na tabela authors)"
     *             ),
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Exemplo"
     *             ),
     *             @OA\Property(
     *                 property="year",
     *                 type="string",
     *                 example="2008"
     *             ),
     *             @OA\Property(
     *                 property="genre",
     *                 type="string",
     *                 example="Teste"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Livro criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'author_id' => 'required|exists:authors,id',
            'title'     => 'required|string|max:255',
            'year'      => 'nullable|digits:4',
            'genre'     => 'nullable|string|max:255',
        ]);

        $book = $this->booksService->create($data);

        return response()->json($book, 201);
    }

    /**
     * @OA\Get(
     *     path="/books/{id}",
     *     summary="Mostrar detalhes de um livro",
     *     tags={"Books"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Livro encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Livro não encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado"
     *     )
     * )
     */
    public function show(string $id)
    {
        return response()->json($this->booksService->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/books/{id}",
     *     summary="Atualizar livro",
     *     tags={"Books"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="author_id",
     *                 type="integer",
     *                 example=1,
     *                 description="ID do autor (opcional na atualização, mas se enviado deve existir)"
     *             ),
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="teste (Atualizado)"
     *             ),
     *             @OA\Property(
     *                 property="year",
     *                 type="string",
     *                 example="2009"
     *             ),
     *             @OA\Property(
     *                 property="genre",
     *                 type="string",
     *                 example="Software Engineering"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Livro atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Livro não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'author_id' => 'sometimes|exists:authors,id',
            'title'     => 'sometimes|required|string|max:255',
            'year'      => 'nullable|digits:4',
            'genre'     => 'nullable|string|max:255',
        ]);

        $book = $this->booksService->update($id, $data);

        return response()->json($book);
    }


    /**
     * @OA\Delete(
     *     path="/books/{id}",
     *     summary="Deletar livro",
     *     tags={"Books"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Livro deletado com sucesso (sem conteúdo)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Livro não encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autenticado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->booksService->delete($id);

        return response()->json([], 204);
    }
}
