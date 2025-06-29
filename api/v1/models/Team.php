<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class Team extends BaseModel {
    protected $table = 'time_cartola';

    public function getTeams() {
        return $this->read($this->table);
    }

    public function getTeamByName($name) {
        $conditions = ['nome' => $nome];
        return $this->read($this->table, $conditions);
    }
        
     
    public function getTeamById($id) {
        $conditions = ['id_time_cartola' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteTeamById($id) {
        $conditions = ['id_time_cartola' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createTeam($data) {
        $requiredFields = [	
            'id_cartoleiro',
            'ind_representante',
            'nome',
            'pontos',
            'ano'
            ];
        foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return ['error' => "Field $field is required"];
                }
            }
        
            $fields = [
            'id_cartoleiro'=> $data['id_cartoleiro'],
            'ind_representante'=> $data['ind_representante'],
            'nome'=> $data['nome'],
            'pontos'=> $data['pontos'],
            'ano'=> $data['ano']
            ];
            
            $result = $this->create($this->table, $fields);
        
            if (isset($result['error'])) {
                return ['error' => 'Failed to create register', 'details' => $result['error']];
            }
        
            return $result;
        }

    public function updateTeamById($data,$id) {
    $conditions = ['id_time_cartola' => $id];
    $fields = [];
    if (!empty($data['id_cartoleiro'])) {
        $fields['id_cartoleiro'] = $data['id_cartoleiro'];
    }
    if (!empty($data['ind_representante'])) {
        $fields['ind_representante'] = $data['ind_representante'];
    }
    if (!empty($data['nome'])) {
        $fields['nome'] = $data['nome'];
    }
    if (!empty($data['pontos'])) {
        $fields['pontos'] = $data['pontos'];
    }
    if (!empty($data['ano'])) {
        $fields['ano'] = $data['ano'];
    }
    if (empty($fields)) {
        return ['error' => 'No fields to update'];
    }
    return  $this->update($this->table, $fields,$conditions);
 }
}