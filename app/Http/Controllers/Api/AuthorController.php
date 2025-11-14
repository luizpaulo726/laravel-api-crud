<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct(
        protected AuthorService $authorsRepository
    )
    {
    }


    /**
     * @OA\Get(
     *     path="/authors",
     *     summary="Listar autores",
     *     tags={"Authors"},
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
     *         description="Lista paginada de autores"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return response()->json($this->authorsRepository->list($perPage));
    }

    /**
     * @OA\Post(
     *     path="/authors",
     *     summary="Criar autor",
     *     tags={"Authors"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Robert C. Martin"),
     *             @OA\Property(property="bio", type="string", example="Autor de Clean Code")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Autor criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author = $this->authorsRepository->create($data);

        return response()->json($author, 201);
    }

    /**
     * @OA\Get(
     *     path="/authors/{id}",
     *     summary="Mostrar autor",
     *     tags={"Authors"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do autor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Autor encontrado"),
     *     @OA\Response(response=404, description="Autor não encontrado")
     * )
     */
    public function show(string $id)
    {
        return response()->json($this->authorsRepository->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/authors/{id}",
     *     summary="Atualizar autor",
     *     tags={"Authors"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do autor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Robert C. Martin"),
     *             @OA\Property(property="bio", type="string", example="Autor de Clean Code (atualizado)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autor atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Autor não encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author = $this->authorsRepository->update($id, $data);

        return response()->json($author);
    }

    /**
     * @OA\Delete(
     *     path="/authors/{id}",
     *     summary="Deletar autor",
     *     tags={"Authors"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do autor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Autor deletado com sucesso (sem conteúdo)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Autor não encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $this->authorsRepository->delete($id);

        return response()->json([], 204);
    }
}
