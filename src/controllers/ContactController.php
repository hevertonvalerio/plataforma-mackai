<?php
/**
 * Controlador da Página de Contato
 */

require_once __DIR__ . '/BaseController.php';

class ContactController extends BaseController {
    
    public function index() {
        $data = [
            'pageTitle' => 'Contato',
            'pageDescription' => 'Entre em contato com a Liga MackAI',
            'currentPage' => 'contact',
            'additionalCSS' => ['contact'],
            'additionalJS' => ['contact']
        ];
        
        // Verificar se é uma submissão do formulário
        if ($this->isPost()) {
            $this->handleContactForm($data);
        } else {
            $this->render('contact/index', $data);
        }
    }
    
    private function handleContactForm(&$data) {
        try {
            $postData = $this->getPostData();
            
            // Validar dados
            $errors = $this->validate($postData, [
                'nome' => 'required|min:2|max:255',
                'email' => 'required|email|max:255',
                'assunto' => 'max:255',
                'mensagem' => 'required|min:10|max:2000'
            ]);
            
            if (!empty($errors)) {
                $data['errors'] = $errors;
                $data['formData'] = $postData;
                $this->render('contact/index', $data);
                return;
            }
            
            // Salvar no banco de dados
            $stmt = $this->db->prepare("
                INSERT INTO contatos (nome, email, assunto, mensagem, ip, user_agent) 
                VALUES (:nome, :email, :assunto, :mensagem, :ip, :user_agent)
            ");
            
            $stmt->execute([
                ':nome' => $postData['nome'],
                ':email' => $postData['email'],
                ':assunto' => $postData['assunto'] ?? 'Contato via site',
                ':mensagem' => $postData['mensagem'],
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
            
            // Sucesso
            $data['success'] = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
            $this->render('contact/index', $data);
            
        } catch (Exception $e) {
            error_log("Erro ao processar formulário de contato: " . $e->getMessage());
            $data['error'] = 'Erro ao enviar mensagem. Tente novamente mais tarde.';
            $data['formData'] = $postData ?? [];
            $this->render('contact/index', $data);
        }
    }
}
