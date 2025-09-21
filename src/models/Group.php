<?php
/**
 * Modelo para Grupos
 */

require_once __DIR__ . '/BaseModel.php';

class Group extends BaseModel {
    protected $table = 'grupo';
    
    /**
     * Buscar grupos com contagem de encontros
     */
    public function findAllWithMeetingCount() {
        $sql = "SELECT 
                    G.id, G.nome, G.created, G.updated,
                    COUNT(E.id) as total_encontros
                FROM grupo G 
                LEFT JOIN encontro E ON G.id = E.grupo 
                GROUP BY G.id, G.nome, G.created, G.updated
                ORDER BY G.nome ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Buscar grupo com seus encontros
     */
    public function findWithMeetings($id) {
        $group = $this->findById($id);
        if (!$group) {
            return null;
        }
        
        $sql = "SELECT 
                    E.id, E.nome, E.data, E.texto, E.video,
                    P.nome as periodo_nome
                FROM encontro E 
                LEFT JOIN periodo P ON E.periodo = P.id 
                WHERE E.grupo = :grupo 
                ORDER BY E.data DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':grupo', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $group['encontros'] = $stmt->fetchAll();
        return $group;
    }
    
    /**
     * Buscar grupos ativos (com encontros)
     */
    public function findActive() {
        $sql = "SELECT DISTINCT 
                    G.id, G.nome, G.created, G.updated
                FROM grupo G 
                INNER JOIN encontro E ON G.id = E.grupo 
                ORDER BY G.nome ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
