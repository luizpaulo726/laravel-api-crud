Laravel API CRUD – Livros & Autores 📚

Este projeto é uma API em Laravel para gerenciar autores e livros, com:

- CRUD completo de Authors e Books
- Autenticação de usuários com Laravel Sanctum (login e logout)
- Endpoint para reset de senha
- Documentação da API com Swagger
- Ambiente pronto com Docker + MySQL
- Testes automatizados com PHPUnit

1. Tecnologias utilizadas
- PHP 8.2+
- Laravel 12
- Laravel Sanctum
- MySQL 8 (via Docker)
- Docker e Docker Compose
- Swagger (L5-Swagger)
- PHPUnit

2. Como rodar o projeto com Docker

2.1. Clonar o repositório

git clone https://github.com/luizpaulo726/laravel-api-crud.git
cd laravel-api-crud

2.2. Copiar o arquivo de ambiente

cp .env.example .env

No .env, deixe a parte do banco assim (para usar o MySQL do Docker):

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=laravel
DB_PASSWORD=laravel

2.3. Subir os containers

docker compose up -d --build

Isso vai subir:

- app  → PHP / Laravel
- nginx → servidor web (porta 8000)
- mysql → banco de dados (porta 3307 no host)

2.4. Instalar as dependências do Laravel

docker compose exec app composer install

2.5. Gerar a chave da aplicação

docker compose exec app php artisan key:generate

2.6. Rodar as migrations

docker compose exec app php artisan migrate

Depois disso o banco já estará pronto com as tabelas necessárias.

3. Endpoints principais

A API está disponível em:

http://localhost:8000

3.1. Autenticação

- POST /api/auth/register – Registrar um novo usuário
- POST /api/auth/login – Fazer login e receber um token
- POST /api/auth/logout – Logout (revoga o token atual)

As rotas protegidas usam Bearer Token (Sanctum).
Depois do login, envie o header:

Authorization: Bearer SEU_TOKEN_AQUI
Accept: application/json

3.2. Authors

CRUD de autores (rotas protegidas por autenticação):

- GET    /api/authors – Listar autores
- POST   /api/authors – Criar autor
- GET    /api/authors/{id} – Detalhar autor
- PUT    /api/authors/{id} – Atualizar autor
- DELETE /api/authors/{id} – Remover autor

3.3. Books

CRUD de livros (também protegido):

- GET    /api/books – Listar livros
- POST   /api/books – Criar livro
- GET    /api/books/{id} – Detalhar livro
- PUT    /api/books/{id} – Atualizar livro
- DELETE /api/books/{id} – Remover livro

4. Documentação Swagger

La documentação interativa da API está disponível em:

http://localhost:8000/api/documentation

Por lá você consegue:

- Ver todos os endpoints
- Enviar requisições diretamente pela interface
- Testar autenticação com Bearer Token

5. Testes automatizados

Os testes usam PHPUnit e cobrem os fluxos de:

- Autenticação
- CRUD de Authors
- CRUD de Books

Para rodar os testes:

docker compose exec app php artisan test

6. Coleção do Postman

O repositório contém uma coleção do Postman com os principais endpoints da API
(endpoints de autenticação, autores e livros).

Basta importar o arquivo de coleção (*.postman_collection.json) no Postman e:

1. Fazer login para obter o token
2. Configurar o header Authorization: Bearer <token>
3. Testar os endpoints de Authors e Books

7. Rodar sem Docker (opcional)

Se preferir rodar sem Docker, você vai precisar de:

- PHP 8.2+
- Composer
- MySQL
- Extensões do PHP compatíveis com Laravel

Passos resumidos:

composer install
cp .env.example .env
# Ajustar dados do banco no .env
php artisan key:generate
php artisan migrate
php artisan serve

A API ficará disponível em:

http://localhost:8000

Se tiver qualquer problema ao subir com Docker, rodar as migrations ou usar os endpoints, é só ajustar o .env conforme seu ambiente.
