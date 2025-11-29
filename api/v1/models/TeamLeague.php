<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class TeamLeague extends BaseModel {
    protected $table = 'time_liga';

    public function getTeamLeagues() {
        return $this->read($this->table);
    }

    public function getTeamLeagueByLeagueId($id_liga) {
        $conditions = ['id_liga' => $id_liga];
        return $this->read($this->table, $conditions);
    }

    public function deleteTeamLeague($id_liga, $id_time_cartola) {
        $conditions = [
            'id_liga' => $id_liga,
            'id_time_cartola' => $id_time_cartola
        ];
        return $this->delete($this->table, $conditions);
    }

    public function createTeamLeague($data) {
        $requiredFields = [	
            'id_liga',
            'id_time_cartola'
            ];
        foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return ['error' => "Field $field is required"];
                }
            }
        
            $fields = [
            'id_liga'=> $data['id_liga'],
            'id_time_cartola'=> $data['id_time_cartola']
            ];
            
            $result = $this->create($this->table, $fields);
        
            if (isset($result['error'])) {
                return ['error' => 'Failed to create register', 'details' => $result['error']];
            }
        
            return $result;
        }
}
