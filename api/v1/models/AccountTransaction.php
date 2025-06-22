<?php
require_once 'BaseModel.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class AccountTransaction extends BaseModel {
    protected $table = 'conta_movimento';

    public function getAccountTransactions() {
        return $this->read($this->table);
    }     
     
    public function getAccountTransactionById($id) {
        $conditions = ['id' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteAccountTransactionById($id) {
        $conditions = ['id' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createAccountTransaction($data) {
        $requiredFields = ['id_conta', 'id_usuario', 'valor_vencimento','data_venc'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['error' => "Field $field is required"];
            }
        }

        $fields = [
            'id_conta' => $data['id_conta'],
            'id_usuario' => $data['id_usuario'],
            'valor_vencimento' => $data['valor_vencimento'],
            'data_venc' => $data['data_venc']
        ];
        
        $result = $this->create($this->table, $fields);

        if (isset($result['error'])) {
            return ['error' => 'Failed to create AccountTransaction', 'details' => $result['error']];
        }

        return $result;
    }

    public function updateAccountTransactionById($data,$id) {
        $conditions = ['id' => $id];
        $fields = [];
        if (!empty($data['id_conta'])) {
            $fields['id_conta'] = $data['id_conta'];
        }
        if (!empty($data['id_usuario'])) {
            $fields['id_usuario'] = $data['id_usuario'];
        }
        if (!empty($data['valor_vencimento'])) {
            $fields['valor_vencimento'] = $data['valor_vencimento'];
        }
        if (!empty($data['valor_pagto'])) {
            $fields['valor_pagto'] = $data['valor_pagto'];
        }
        if (!empty($data['data_venc'])) {
            $fields['data_venc'] = $data['data_venc'];
        }
        if (!empty($data['data_pgto'])) {
            $fields['data_pgto'] = $data['data_pgto'];
        }
        if (empty($fields)) {
            return ['error' => 'No fields to update'];
        }
        return  $this->update($this->table, $fields,$conditions);
     }
}