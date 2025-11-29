<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class Award extends BaseModel {
    protected $table = 'premiacao';

    public function getAwards() {
        return $this->read($this->table);
    }

    public function getAwardById($id) {
        $conditions = ['id_premiacao' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteAwardById($id) {
        $conditions = ['id_premiacao' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createAward($data) {
        $requiredFields = [	
            'id_liga',
            'pos',
            'valor'
            ];
        foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return ['error' => "Field $field is required"];
                }
            }
        
            $fields = [
            'id_liga'=> $data['id_liga'],
            'pos'=> $data['pos'],
            'valor'=> $data['valor']
            ];
            
            $result = $this->create($this->table, $fields);
        
            if (isset($result['error'])) {
                return ['error' => 'Failed to create register', 'details' => $result['error']];
            }
        
            return $result;
        }

    public function updateAwardById($data,$id) {
    $conditions = ['id_premiacao' => $id];
    $fields = [];
    if (!empty($data['id_liga'])) {
        $fields['id_liga'] = $data['id_liga'];
    }
    if (!empty($data['pos'])) {
        $fields['pos'] = $data['pos'];
    }
    if (!empty($data['valor'])) {
        $fields['valor'] = $data['valor'];
    }
    if (empty($fields)) {
        return ['error' => 'No fields to update'];
    }
    return  $this->update($this->table, $fields,$conditions);
 }
}
