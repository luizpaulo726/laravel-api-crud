FROM php:8.2-fpm

# Instala dependências de sistema e extensões do PHP necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer copiando da imagem oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório da aplicação
WORKDIR /var/www/html

# Copia os arquivos do projeto para dentro do container
COPY . /var/www/html

# Ajusta permissões para diretórios usados pelo Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
