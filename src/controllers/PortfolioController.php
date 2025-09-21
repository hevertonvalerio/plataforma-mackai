<?php
/**
 * Controlador da Página de Portfólio
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/Group.php';

class PortfolioController extends BaseController {
    
    public function index() {
        try {
            $meetingModel = new Meeting();
            $groupModel = new Group();
            
            // Buscar encontros organizados por grupo
            $groups = $groupModel->findAllWithMeetingCount();
            $meetingsByGroup = [];
            
            foreach ($groups as $group) {
                $meetings = $meetingModel->findByGroup($group['id']);
                if (!empty($meetings)) {
                    $meetingsByGroup[$group['id']] = [
                        'group' => $group,
                        'meetings' => array_slice($meetings, 0, 3) // Limitar a 3 por grupo
                    ];
                }
            }
            
            // Projetos destacados (baseado nos encontros de projetos)
            $featuredProjects = $meetingModel->findWhere(
                'grupo = :grupo AND ativo = 1', 
                [':grupo' => 4] // Grupo "Projetos Práticos"
            );
            
            // Estatísticas do portfólio
            $stats = [
                'total_projects' => count($featuredProjects),
                'total_presentations' => $meetingModel->count('ativo = 1'),
                'research_areas' => count($groups),
                'total_hours' => $this->calculateTotalHours()
            ];
            
            $data = [
                'pageTitle' => 'Portfólio',
                'pageDescription' => 'Conheça os projetos e trabalhos desenvolvidos pela Liga MackAI',
                'currentPage' => 'portfolio',
                'meetingsByGroup' => $meetingsByGroup,
                'featuredProjects' => $featuredProjects,
                'stats' => $stats,
                'additionalCSS' => ['portfolio'],
                'additionalJS' => ['portfolio']
            ];
            
            $this->render('portfolio/index', $data);
            
        } catch (Exception $e) {
            error_log("Erro na PortfolioController: " . $e->getMessage());
            
            $data = [
                'pageTitle' => 'Portfólio',
                'currentPage' => 'portfolio',
                'meetingsByGroup' => [],
                'featuredProjects' => [],
                'stats' => [
                    'total_projects' => 0,
                    'total_presentations' => 0,
                    'research_areas' => 0,
                    'total_hours' => 0
                ],
                'error' => 'Erro ao carregar portfólio. Tente novamente mais tarde.'
            ];
            
            $this->render('portfolio/index', $data);
        }
    }
    
    /**
     * Calcular total de horas de conteúdo
     */
    private function calculateTotalHours() {
        try {
            $stmt = $this->db->prepare("SELECT SUM(duracao) as total FROM encontro WHERE ativo = 1 AND duracao IS NOT NULL");
            $stmt->execute();
            $result = $stmt->fetch();
            
            $totalMinutes = $result['total'] ?? 0;
            return round($totalMinutes / 60, 1); // Converter para horas
            
        } catch (Exception $e) {
            return 0;
        }
    }
}
