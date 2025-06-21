<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class Account extends BaseModel {
    protected $table = 'conta';

    public function getAccounts() {
        return $this->read($this->table);
    }

    public function getAccountByDescription($description) {
        $conditions = ['descricao' => $nome];
        return $this->read($this->table, $conditions);
    }
        
     
    public function getAccountById($id) {
        $conditions = ['id' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteAccountById($id) {
        $conditions = ['id' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createAccount($data) {
        $requiredFields = ['descricao', 'tipo'];
foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['error' => "Field $field is required"];
            }
        }

        $fields = [
            'descricao' => $data['descricao'],
            'tipo' => $data['tipo']
        ];
        
        $result = $this->create($this->table, $fields);

        if (isset($result['error'])) {
            return ['error' => 'Failed to create Account', 'details' => $result['error']];
        }

        return $result;
    }

    public function updateAccountById($data,$id) {
        $conditions = ['id' => $id];
        $fields = [];
        if (!empty($data['descricao'])) {
            $fields['descricao'] = $data['descricao'];
        }
        if (!empty($data['tipo'])) {
            $fields['tipo'] = $data['tipo'];
        }
        if (empty($fields)) {
            return ['error' => 'No fields to update'];
        }
        return  $this->update($this->table, $fields,$conditions);
     }
}