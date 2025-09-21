<?php
/**
 * Controlador Base
 */

abstract class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Renderizar view com layout
     */
    protected function render($view, $data = [], $layout = 'base') {
        // Extrair variáveis para o escopo da view
        extract($data);
        
        // Capturar conteúdo da view
        ob_start();
        include __DIR__ . "/../views/{$view}.php";
        $content = ob_get_clean();
        
        // Renderizar com layout
        include __DIR__ . "/../views/layout/{$layout}.php";
    }
    
    /**
     * Renderizar apenas a view (sem layout)
     */
    protected function renderPartial($view, $data = []) {
        extract($data);
        include __DIR__ . "/../views/{$view}.php";
    }
    
    /**
     * Retornar JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    /**
     * Redirecionar
     */
    protected function redirect($url, $statusCode = 302) {
        http_response_code($statusCode);
        header("Location: $url");
        exit;
    }
    
    /**
     * Validar dados de entrada
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "O campo {$field} é obrigatório";
                continue;
            }
            
            if (strpos($rule, 'email') !== false && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "O campo {$field} deve ser um email válido";
            }
            
            if (preg_match('/min:(\d+)/', $rule, $matches)) {
                $min = $matches[1];
                if (strlen($value) < $min) {
                    $errors[$field] = "O campo {$field} deve ter pelo menos {$min} caracteres";
                }
            }
            
            if (preg_match('/max:(\d+)/', $rule, $matches)) {
                $max = $matches[1];
                if (strlen($value) > $max) {
                    $errors[$field] = "O campo {$field} deve ter no máximo {$max} caracteres";
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Sanitizar dados de entrada
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Verificar se é requisição POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Verificar se é requisição AJAX
     */
    protected function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Obter dados POST sanitizados
     */
    protected function getPostData() {
        return $this->sanitize($_POST);
    }
    
    /**
     * Obter dados GET sanitizados
     */
    protected function getGetData() {
        return $this->sanitize($_GET);
    }
}
