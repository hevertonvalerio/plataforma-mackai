<?php
/**
 * Modelo para Períodos
 */

require_once __DIR__ . '/BaseModel.php';

class Period extends BaseModel {
    protected $table = 'periodo';
    
    /**
     * Buscar períodos com contagem de encontros
     */
    public function findAllWithMeetingCount() {
        $sql = "SELECT 
                    P.id, P.nome, P.created, P.updated,
                    COUNT(E.id) as total_encontros
                FROM periodo P 
                LEFT JOIN encontro E ON P.id = E.periodo 
                GROUP BY P.id, P.nome, P.created, P.updated
                ORDER BY P.nome DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar período atual (mais recente)
     */
    public function findCurrent() {
        $stmt = $this->db->prepare("SELECT * FROM periodo ORDER BY nome DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Buscar períodos ativos (com encontros)
     */
    public function findActive() {
        $sql = "SELECT DISTINCT 
                    P.id, P.nome, P.created, P.updated
                FROM periodo P 
                INNER JOIN encontro E ON P.id = E.periodo 
                ORDER BY P.nome DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
