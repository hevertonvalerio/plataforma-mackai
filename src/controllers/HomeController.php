<?php
/**
 * Controlador da Página Inicial
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/Group.php';
require_once __DIR__ . '/../models/Period.php';

class HomeController extends BaseController {
    
    public function index() {
        try {
            // Buscar dados para a página inicial
            $meetingModel = new Meeting();
            $groupModel = new Group();
            $periodModel = new Period();
            
            // Encontros recentes
            $recentMeetings = $meetingModel->findRecent(3);
            
            // Grupos ativos
            $activeGroups = $groupModel->findActive();
            
            // Estatísticas
            $stats = [
                'total_meetings' => $meetingModel->count(),
                'total_groups' => $groupModel->count(),
                'current_period' => $periodModel->findCurrent()
            ];
            
            // Dados para a view
            $data = [
                'pageTitle' => 'Início',
                'pageDescription' => 'Liga Acadêmica de Ciência de Dados e Inteligência Artificial da Universidade Presbiteriana Mackenzie',
                'currentPage' => 'home',
                'recentMeetings' => $recentMeetings,
                'activeGroups' => $activeGroups,
                'stats' => $stats,
                'additionalCSS' => ['home'],
                'additionalJS' => ['home']
            ];
            
            $this->render('home/index', $data);
            
        } catch (Exception $e) {
            error_log("Erro na HomeController: " . $e->getMessage());
            
            // Em caso de erro, mostrar página básica
            $data = [
                'pageTitle' => 'Início',
                'pageDescription' => 'Liga Acadêmica de Ciência de Dados e IA',
                'currentPage' => 'home',
                'recentMeetings' => [],
                'activeGroups' => [],
                'stats' => [
                    'total_meetings' => 0,
                    'total_groups' => 0,
                    'current_period' => null
                ],
                'error' => 'Erro ao carregar dados. Tente novamente mais tarde.'
            ];
            
            $this->render('home/index', $data);
        }
    }
}
