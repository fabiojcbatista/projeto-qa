<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class RoundScore extends BaseModel {
    protected $table = 'pontuacao_rodada';

    public function getRoundScores() {
        return $this->read($this->table);
    }

    public function getRoundScoreById($id) {
        $conditions = ['id_pontuacao_rodada' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteRoundScoreById($id) {
        $conditions = ['id_pontuacao_rodada' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createRoundScore($data) {
        $requiredFields = [	
            'id_time_cartola',
            'pontos',
            'ano'
            ];
        foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return ['error' => "Field $field is required"];
                }
            }
        
            $fields = [
            'id_time_cartola'=> $data['id_time_cartola'],
            'pontos'=> $data['pontos'],
            'ano'=> $data['ano']
            ];
            
            $result = $this->create($this->table, $fields);
        
            if (isset($result['error'])) {
                return ['error' => 'Failed to create register', 'details' => $result['error']];
            }
        
            return $result;
        }

    public function updateRoundScoreById($data,$id) {
    $conditions = ['id_pontuacao_rodada' => $id];
    $fields = [];
    if (!empty($data['id_time_cartola'])) {
        $fields['id_time_cartola'] = $data['id_time_cartola'];
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
