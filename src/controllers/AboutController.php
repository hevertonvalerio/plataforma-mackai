<?php
/**
 * Controlador da Página Sobre
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/Group.php';

class AboutController extends BaseController {
    
    public function index() {
        try {
            $meetingModel = new Meeting();
            $groupModel = new Group();
            
            // Estatísticas para a página sobre
            $stats = [
                'total_meetings' => $meetingModel->count(),
                'total_groups' => $groupModel->count(),
                'foundation_year' => 2023, // Ano de fundação da liga
                'active_members' => 50 // Número estimado de membros ativos
            ];
            
            // Dados dos grupos para seção de áreas de atuação
            $groups = $groupModel->findAllWithMeetingCount();
            
            $data = [
                'pageTitle' => 'Sobre Nós',
                'pageDescription' => 'Conheça a Liga Acadêmica de Ciência de Dados e Inteligência Artificial da Universidade Presbiteriana Mackenzie',
                'currentPage' => 'about',
                'stats' => $stats,
                'groups' => $groups,
                'additionalCSS' => ['about'],
                'additionalJS' => ['about']
            ];
            
            $this->render('about/index', $data);
            
        } catch (Exception $e) {
            error_log("Erro na AboutController: " . $e->getMessage());
            
            $data = [
                'pageTitle' => 'Sobre Nós',
                'currentPage' => 'about',
                'stats' => [
                    'total_meetings' => 0,
                    'total_groups' => 0,
                    'foundation_year' => 2023,
                    'active_members' => 50
                ],
                'groups' => [],
                'error' => 'Erro ao carregar informações. Tente novamente mais tarde.'
            ];
            
            $this->render('about/index', $data);
        }
    }
}
