<?php
/**
 * MackAI - Plataforma Unificada
 * Ponto de entrada da aplicação
 */

// Configurações básicas
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Sao_Paulo');

// Autoload e configurações
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/config/routes.php';

// Inicializar roteamento
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';

// Roteamento simples
switch ($path) {
    case '/':
        require_once __DIR__ . '/../src/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case '/sobre':
        require_once __DIR__ . '/../src/controllers/AboutController.php';
        $controller = new AboutController();
        $controller->index();
        break;
        
    case '/portfolio':
        require_once __DIR__ . '/../src/controllers/PortfolioController.php';
        $controller = new PortfolioController();
        $controller->index();
        break;
        
    case '/encontros':
        require_once __DIR__ . '/../src/controllers/MeetingsController.php';
        $controller = new MeetingsController();
        $controller->index();
        break;
        
    case '/contato':
        require_once __DIR__ . '/../src/controllers/ContactController.php';
        $controller = new ContactController();
        $controller->index();
        break;
        
    default:
        // Verificar se é uma rota de encontro específico
        if (preg_match('/^\/encontro\/(\d+)$/', $path, $matches)) {
            require_once __DIR__ . '/../src/controllers/MeetingsController.php';
            $controller = new MeetingsController();
            $controller->show($matches[1]);
        } else {
            // 404 - Página não encontrada
            http_response_code(404);
            require_once __DIR__ . '/../src/views/404.php';
        }
        break;
}
