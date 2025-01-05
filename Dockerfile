FROM php:8.3-fpm

# Instalar dependências e o driver do MySQL/MariaDB
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmariadb-dev-compat \
    libmariadb-dev \
    curl \
    git \
    zip \
    unzip \
    default-mysql-client \
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar os arquivos do projeto para dentro do contêiner
COPY ./api_cliente_cartao /var/www
# Definir o diretório de trabalho
WORKDIR /var/www