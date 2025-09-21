<?php
/**
 * Controlador dos Encontros
 */

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/Meeting.php';
require_once __DIR__ . '/../models/Group.php';
require_once __DIR__ . '/../models/Period.php';

class MeetingsController extends BaseController {
    
    /**
     * Listar todos os encontros
     */
    public function index() {
        try {
            $meetingModel = new Meeting();
            $groupModel = new Group();
            $periodModel = new Period();
            
            // Filtros
            $filters = $this->getGetData();
            $groupId = $filters['grupo'] ?? null;
            $periodId = $filters['periodo'] ?? null;
            
            // Buscar encontros
            if ($groupId && $periodId) {
                $meetings = $meetingModel->findByGroupAndPeriod($groupId, $periodId);
            } else {
                $meetings = $meetingModel->findAllWithDetails();
            }
            
            // Buscar grupos e períodos para filtros
            $groups = $groupModel->findAllWithMeetingCount();
            $periods = $periodModel->findAllWithMeetingCount();
            
            $data = [
                'pageTitle' => 'Encontros',
                'pageDescription' => 'Encontros e aulas da Liga MackAI',
                'currentPage' => 'meetings',
                'meetings' => $meetings,
                'groups' => $groups,
                'periods' => $periods,
                'currentGroup' => $groupId,
                'currentPeriod' => $periodId,
                'additionalCSS' => ['meetings'],
                'additionalJS' => ['meetings']
            ];
            
            $this->render('meetings/index', $data);
            
        } catch (Exception $e) {
            error_log("Erro na MeetingsController::index: " . $e->getMessage());
            
            $data = [
                'pageTitle' => 'Encontros',
                'currentPage' => 'meetings',
                'meetings' => [],
                'groups' => [],
                'periods' => [],
                'error' => 'Erro ao carregar encontros. Tente novamente mais tarde.'
            ];
            
            $this->render('meetings/index', $data);
        }
    }
    
    /**
     * Exibir encontro específico
     */
    public function show($id) {
        try {
            $meetingModel = new Meeting();
            
            // Buscar encontro
            $meeting = $meetingModel->findByIdWithDetails($id);
            
            if (!$meeting) {
                http_response_code(404);
                $this->render('errors/404', [
                    'pageTitle' => 'Encontro não encontrado',
                    'message' => 'O encontro solicitado não foi encontrado.'
                ]);
                return;
            }
            
            // Buscar outros encontros do mesmo grupo e período
            $relatedMeetings = $meetingModel->findByGroupAndPeriod(
                $meeting['grupo'], 
                $meeting['periodo']
            );
            
            // Remover o encontro atual da lista
            $relatedMeetings = array_filter($relatedMeetings, function($m) use ($id) {
                return $m['id'] != $id;
            });
            
            $data = [
                'pageTitle' => $meeting['nome'],
                'pageDescription' => substr(strip_tags($meeting['texto']), 0, 160),
                'currentPage' => 'meetings',
                'meeting' => $meeting,
                'relatedMeetings' => $relatedMeetings,
                'additionalCSS' => ['meeting-detail'],
                'additionalJS' => ['meeting-detail']
            ];
            
            $this->render('meetings/show', $data);
            
        } catch (Exception $e) {
            error_log("Erro na MeetingsController::show: " . $e->getMessage());
            
            http_response_code(500);
            $this->render('errors/500', [
                'pageTitle' => 'Erro interno',
                'message' => 'Erro ao carregar o encontro. Tente novamente mais tarde.'
            ]);
        }
    }
}
