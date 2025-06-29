<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class Player extends BaseModel {
    protected $table = 'cartoleiro';

    public function getPlayers() {
        return $this->read($this->table);
    }

    public function getPlayerByName($name) {
        $conditions = ['nome' => $nome];
        return $this->read($this->table, $conditions);
    }
        
     
    public function getPlayerById($id) {
        $conditions = ['id_cartoleiro' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deletePlayerById($id) {
        $conditions = ['id_cartoleiro' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createPlayer($data) {
        $requiredFields = ['nome'];
foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['error' => "Field $field is required"];
            }
        }

        $fields = [
            'nome' => $data['nome']
        ];
        
        $result = $this->create($this->table, $fields);

        if (isset($result['error'])) {
            return ['error' => 'Failed to create Player', 'details' => $result['error']];
        }

        return $result;
    }

    public function updatePlayerById($data,$id) {
        $conditions = ['id_cartoleiro' => $id];
        $fields = [];
        if (!empty($data['nome'])) {
            $fields['nome'] = $data['nome'];
        }
        if (empty($fields)) {
            return ['error' => 'No fields to update'];
        }
        return  $this->update($this->table, $fields,$conditions);
     }
}