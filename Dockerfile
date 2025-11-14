FROM php:8.2-fpm

# Instala dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Diretório da aplicação
WORKDIR /var/www/html

# Opcional: se quiser copiar tudo na build
COPY . /var/www/html

# Permissões para storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache
