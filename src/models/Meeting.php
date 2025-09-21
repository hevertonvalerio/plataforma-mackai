<?php
/**
 * Modelo para Encontros
 */

require_once __DIR__ . '/BaseModel.php';

class Meeting extends BaseModel {
    protected $table = 'encontro';
    
    /**
     * Buscar encontros com informações de grupo e período
     */
    public function findAllWithDetails() {
        $sql = "SELECT 
                    E.id, E.grupo, E.periodo, E.data, E.nome, E.texto, E.video,
                    G.nome AS grupo_nome, 
                    P.nome AS periodo_nome,
                    E.created, E.updated
                FROM encontro E 
                LEFT JOIN grupo G ON E.grupo = G.id 
                LEFT JOIN periodo P ON E.periodo = P.id 
                ORDER BY E.data DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar encontro por ID com detalhes
     */
    public function findByIdWithDetails($id) {
        $sql = "SELECT 
                    E.id, E.grupo, E.periodo, E.data, E.nome, E.texto, E.video,
                    G.nome AS grupo_nome, 
                    P.nome AS periodo_nome,
                    E.created, E.updated
                FROM encontro E 
                LEFT JOIN grupo G ON E.grupo = G.id 
                LEFT JOIN periodo P ON E.periodo = P.id 
                WHERE E.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Buscar encontros por grupo e período
     */
    public function findByGroupAndPeriod($groupId, $periodId) {
        $sql = "SELECT 
                    E.id, E.nome, E.data, E.video,
                    G.nome AS grupo_nome, 
                    P.nome AS periodo_nome
                FROM encontro E 
                LEFT JOIN grupo G ON E.grupo = G.id 
                LEFT JOIN periodo P ON E.periodo = P.id 
                WHERE E.grupo = :grupo AND E.periodo = :periodo 
                ORDER BY E.data ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':grupo', $groupId, PDO::PARAM_INT);
        $stmt->bindValue(':periodo', $periodId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar encontros recentes
     */
    public function findRecent($limit = 5) {
        $sql = "SELECT 
                    E.id, E.nome, E.data, E.texto,
                    G.nome AS grupo_nome, 
                    P.nome AS periodo_nome
                FROM encontro E 
                LEFT JOIN grupo G ON E.grupo = G.id 
                LEFT JOIN periodo P ON E.periodo = P.id 
                ORDER BY E.data DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar por grupo
     */
    public function findByGroup($groupId) {
        return $this->findWhere('grupo = :grupo', [':grupo' => $groupId]);
    }
    
    /**
     * Formatar data para exibição
     */
    public function formatDate($date, $format = 'd/m/Y H\hi') {
        return date($format, strtotime($date));
    }
    
    /**
     * Extrair ID do vídeo do YouTube
     */
    public function getYouTubeVideoId($video) {
        // Se já for apenas o ID, retorna
        if (strlen($video) === 11 && !strpos($video, '/')) {
            return $video;
        }
        
        // Extrair ID de URLs do YouTube
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $video, $matches);
        return isset($matches[1]) ? $matches[1] : $video;
    }
}
