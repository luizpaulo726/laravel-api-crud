# Laravel API CRUD – Livros & Autores 📚

## 📋 Visão Geral

O **Laravel API CRUD – Livros & Autores** é uma API REST construída em **Laravel 12** para gerenciar:

- Authors (autores)  
- Books (livros)

Ela conta com:

- CRUD completo de **Authors** e **Books**
- Autenticação com **Laravel Sanctum** (login, logout)
- Endpoint para **reset de senha**
- Documentação da API com **Swagger** (`/api/documentation`)
- Ambiente pronto com **Docker + Nginx + MySQL**
- Testes automatizados com **PHPUnit**

---

## 📦 Requisitos

Para usar com Docker:

- Docker  
- Docker Compose  

Para rodar sem Docker (opcional):

- PHP 8.2+
- Composer
- MySQL 8
- Extensões do PHP compatíveis com Laravel

---

## 🐳 Configuração com Docker

### 1️⃣ Clonar o repositório

```bash
git clone https://github.com/luizpaulo726/laravel-api-crud.git
cd laravel-api-crud
```

### 2️⃣ Copiar o arquivo de ambiente

```bash
cp .env.example .env
```

No `.env`, configure o banco para usar o MySQL do Docker:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

### 3️⃣ Subir os containers

```bash
docker compose up -d --build
```

Isso vai subir:

- `app`   → PHP / Laravel  
- `nginx` → servidor web (porta **8000**)  
- `mysql` → banco de dados (porta **3307** no host)

### 4️⃣ Instalar as dependências do Laravel

```bash
docker compose exec app composer install
```

### 5️⃣ Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

### 6️⃣ Rodar as migrations

```bash
docker compose exec app php artisan migrate
```

### 7️⃣ Gerar a documentação Swagger

```bash
docker compose exec app php artisan l5-swagger:generate
```

Depois disso, a API já estará disponível em:

```text
http://localhost:8000
```

E a documentação Swagger em:

```text
http://localhost:8000/api/documentation
```

---

## 🐧 Somente Linux – Permissões de pasta

Se ao acessar a API aparecer erro de **permissão em `storage`**, rode:

```bash
docker compose exec app bash

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exit
```



---

## 🔐 Autenticação

### 🔸 Registro de usuário

**Endpoint**

```http
POST /api/auth/register
```

**Body (JSON)**

```json
{
  "name": "Luiz Paulo",
  "email": "luiz@example.com",
  "password": "senha123",
  "password_confirmation": "senha123"
}
```

---

### 🔸 Login

**Endpoint**

```http
POST /api/auth/login
```

**Body (JSON)**

```json
{
  "email": "luiz@example.com",
  "password": "senha123"
}
```

**Resposta (exemplo)**

```json
{
  "access_token": "1|abcdefg123456",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Luiz Paulo",
    "email": "luiz@example.com"
  }
}
```

Use esse token nas rotas protegidas:

```http
Authorization: Bearer SEU_TOKEN_AQUI
Accept: application/json
```

---

### 🔸 Logout

**Endpoint**

```http
POST /api/auth/logout
```

**Headers**

```http
Authorization: Bearer SEU_TOKEN_AQUI
Accept: application/json
```

---

### 🔸 Esqueci minha senha

**Endpoint**

```http
POST /api/auth/forgot-password
```

**Body**

```json
{
  "email": "luiz@example.com"
}
```

O Laravel enviará um e-mail com o link de reset de senha contendo o `token`.

---

### 🔸 Reset de senha

**Endpoint**

```http
POST /api/auth/reset-password
```

**Body**

```json
{
  "token": "TOKEN_ENVIADO_POR_EMAIL",
  "email": "luiz@example.com",
  "password": "novasenha123",
  "password_confirmation": "novasenha123"
}
```

---

## ✍️ CRUD – Authors

Todas as rotas abaixo exigem autenticação (Bearer Token).

### 🔹 Listar autores

```http
GET /api/authors
```

### 🔹 Criar autor

```http
POST /api/authors
```

**Body**

```json
{
  "name": "Robert C. Martin",
  "bio": "Autor de Clean Code e outros livros de boas práticas."
}
```

### 🔹 Detalhar autor

```http
GET /api/authors/{id}
```

### 🔹 Atualizar autor

```http
PUT /api/authors/{id}
```

**Body**

```json
{
  "name": "Robert C. Martin",
  "bio": "Bio atualizada..."
}
```

### 🔹 Remover autor

```http
DELETE /api/authors/{id}
```

---

## 📚 CRUD – Books

Também exigem autenticação (Bearer Token).

### 🔹 Listar livros

```http
GET /api/books
```

### 🔹 Criar livro

```http
POST /api/books
```

**Body**

```json
{
  "title": "Clean Code",
  "description": "Um guia sobre boas práticas de código limpo.",
  "published_year": 2008,
  "author_id": 1
}
```

### 🔹 Detalhar livro

```http
GET /api/books/{id}
```

### 🔹 Atualizar livro

```http
PUT /api/books/{id}
```

**Body**

```json
{
  "title": "Clean Code (Edição Revisada)",
  "description": "Descrição atualizada...",
  "published_year": 2010,
  "author_id": 1
}
```

### 🔹 Remover livro

```http
DELETE /api/books/{id}
```

---

## 📑 Documentação Swagger

A documentação interativa da API está em:

```text
http://localhost:8000/api/documentation
```

Por lá você consegue:

- Ver todos os endpoints  
- Enviar requisições pela interface  
- Testar autenticação com Bearer Token  

---

## 🧪 Testes automatizados

Os testes utilizam **PHPUnit** e cobrem:

- Autenticação  
- CRUD de Authors  
- CRUD de Books  

Para rodar:

```bash
docker compose exec app php artisan test
```

---

## 🧰 Coleção do Postman

O repositório contém uma coleção do Postman com os principais endpoints.

Passos:

1. Importar o arquivo `*.postman_collection.json` no Postman  
2. Fazer login em `/api/auth/login` para obter o token  
3. Configurar o header:

   ```http
   Authorization: Bearer SEU_TOKEN_AQUI
   ```

4. Testar os endpoints de **Authors** e **Books**

---

## 💻 Rodando sem Docker (opcional)

Se preferir rodar localmente:

```bash
composer install
cp .env.example .env
# Ajuste as variáveis de banco no .env
php artisan key:generate
php artisan migrate
php artisan serve
```

A API ficará disponível em:

```text
http://localhost:8000
```

E o Swagger em:

```text
http://localhost:8000/api/documentation
```
