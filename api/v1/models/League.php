<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class League extends BaseModel {
    protected $table = 'liga';

    public function getLeagues() {
        return $this->read($this->table);
    }

    public function getLeagueById($id) {
        $conditions = ['id_liga' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteLeagueById($id) {
        $conditions = ['id_liga' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createLeague($data) {
        $requiredFields = [	
            'nome',
            'dt_ini',
            'dt_fim'
            ];
        foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return ['error' => "Field $field is required"];
                }
            }
        
            $fields = [
            'nome'=> $data['nome'],
            'dt_ini'=> $data['dt_ini'],
            'dt_fim'=> $data['dt_fim']
            ];
            
            $result = $this->create($this->table, $fields);
        
            if (isset($result['error'])) {
                return ['error' => 'Failed to create register', 'details' => $result['error']];
            }
        
            return $result;
        }

    public function updateLeagueById($data,$id) {
    $conditions = ['id_liga' => $id];
    $fields = [];
    if (!empty($data['nome'])) {
        $fields['nome'] = $data['nome'];
    }
    if (!empty($data['dt_ini'])) {
        $fields['dt_ini'] = $data['dt_ini'];
    }
    if (!empty($data['dt_fim'])) {
        $fields['dt_fim'] = $data['dt_fim'];
    }
    if (empty($fields)) {
        return ['error' => 'No fields to update'];
    }
    return  $this->update($this->table, $fields,$conditions);
 }
}
