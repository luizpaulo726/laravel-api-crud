# Laravel API CRUD – Livros & Autores 📚

Este projeto é uma API em Laravel para gerenciar **autores** e **livros**, com:

- CRUD completo de **Authors** e **Books**
- Autenticação de usuários com **Laravel Sanctum** (login e logout)
- Endpoint para **reset de senha**
- Documentação da API com **Swagger**
- Ambiente pronto com **Docker + MySQL**
- Testes automatizados com **PHPUnit**

---

## 🚀 Tecnologias utilizadas

- PHP 8.2+
- Laravel 12
- Laravel Sanctum
- MySQL 8 (via Docker)
- Docker e Docker Compose
- Swagger (L5-Swagger)
- PHPUnit

---

## 🐳 Como rodar o projeto com Docker

### 1. Clonar o repositório

```bash
git clone https://github.com/luizpaulo726/laravel-api-crud.git
cd laravel-api-crud
2. Copiar o arquivo de ambiente
bash
Copiar código
cp .env.example .env
No .env, deixe a parte do banco assim (para usar o MySQL do Docker):

env
Copiar código
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=laravel
DB_PASSWORD=laravel
3. Subir os containers
bash
Copiar código
docker compose up -d --build
Isso vai subir:

app → PHP / Laravel

nginx → servidor web (porta 8000)

mysql → banco de dados (porta 3307 no host)

4. Instalar as dependências do Laravel
bash
Copiar código
docker compose exec app composer install
5. Gerar a chave da aplicação
bash
Copiar código
docker compose exec app php artisan key:generate
6. Rodar as migrations
bash
Copiar código
docker compose exec app php artisan migrate
Depois disso o banco já estará pronto com as tabelas necessárias.

🌐 Endpoints principais
A API está disponível em:

text
Copiar código
http://localhost:8000
Autenticação
POST /api/auth/register – Registrar um novo usuário

POST /api/auth/login – Fazer login e receber um token

POST /api/auth/logout – Logout (revoga o token atual)

As rotas protegidas usam Bearer Token (Sanctum).
Depois do login, envie o header:

http
Copiar código
Authorization: Bearer SEU_TOKEN_AQUI
Accept: application/json
Authors
CRUD de autores (rotas protegidas por autenticação):

GET /api/authors – Listar autores

POST /api/authors – Criar autor

GET /api/authors/{id} – Detalhar autor

PUT /api/authors/{id} – Atualizar autor

DELETE /api/authors/{id} – Remover autor

Books
CRUD de livros (também protegido):

GET /api/books – Listar livros

POST /api/books – Criar livro

GET /api/books/{id} – Detalhar livro

PUT /api/books/{id} – Atualizar livro

DELETE /api/books/{id} – Remover livro

📑 Documentação Swagger
A documentação interativa da API está disponível em:

text
Copiar código
http://localhost:8000/api/documentation
Por lá você consegue:

Ver todos os endpoints

Enviar requisições diretamente pela interface

Testar autenticação com Bearer Token

🧪 Testes automatizados
Os testes usam PHPUnit e cobrem os fluxos de:

Autenticação

CRUD de Authors

CRUD de Books

Para rodar os testes:

bash
Copiar código
docker compose exec app php artisan test
🧰 Coleção do Postman
O repositório contém uma coleção do Postman com os principais endpoints da API
(endpoints de autenticação, autores e livros).

Basta importar o arquivo de coleção (*.postman_collection.json) no Postman e:

Fazer login para obter o token

Configurar o header Authorization: Bearer <token>

Testar os endpoints de Authors e Books

💡 Rodar sem Docker (opcional)
Se preferir rodar sem Docker, você vai precisar de:

PHP 8.2+

Composer

MySQL

Extensões do PHP compatíveis com Laravel

Passos resumidos:

bash
Copiar código
composer install
cp .env.example .env
# Ajustar dados do banco no .env
php artisan key:generate
php artisan migrate
php artisan serve
A API ficará disponível em:

text
Copiar código
http://localhost:8000
