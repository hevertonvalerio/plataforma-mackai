# Dockerfile para MackAI OP-3
FROM php:8.3-cli

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Definir diretório de trabalho
WORKDIR /app

# Copiar arquivos da aplicação
COPY . /app

# Configurar permissões
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app

# Variáveis de ambiente
ENV PORT=8080
ENV DOCUMENT_ROOT=/app/public

# Expor porta
EXPOSE 8080

# Comando para iniciar o servidor
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t ${DOCUMENT_ROOT}"]
