<?php
/**
 * Configurações de Rotas
 */

// Configurações globais da aplicação
define('APP_NAME', 'MackAI');
define('APP_VERSION', '3.0.0');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8080');

// Configurações de assets
define('ASSETS_URL', BASE_URL . '/assets');
define('IMAGES_URL', ASSETS_URL . '/images');

// Configurações de segurança
define('CSRF_TOKEN_NAME', '_token');
define('SESSION_TIMEOUT', 3600); // 1 hora

// Configurações de cache
define('CACHE_ENABLED', getenv('CACHE_ENABLED') === 'true');
define('CACHE_TTL', 300); // 5 minutos

// Rotas da aplicação
$routes = [
    '/' => 'HomeController@index',
    '/sobre' => 'AboutController@index',
    '/portfolio' => 'PortfolioController@index',
    '/encontros' => 'MeetingsController@index',
    '/encontro/{id}' => 'MeetingsController@show',
    '/contato' => 'ContactController@index',
    '/api/encontros' => 'ApiController@meetings',
    '/api/grupos' => 'ApiController@groups',
];

// Middleware de autenticação (para futuras funcionalidades admin)
$protected_routes = [
    '/admin/*'
];

// Headers de segurança
function setSecurityHeaders() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// Aplicar headers de segurança
setSecurityHeaders();
