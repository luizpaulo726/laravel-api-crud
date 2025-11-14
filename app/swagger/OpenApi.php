<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="API - Autores e Livros",
 *     version="1.0.0",
 *     description="Documentação da API do desafio (Laravel + Sanctum)."
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor local"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApi {}
