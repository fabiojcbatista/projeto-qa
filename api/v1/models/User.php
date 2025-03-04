<?php
require_once 'BaseModel.php';
date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class User extends BaseModel {
    protected $table = 'usuario';

    public function getUsers() {
        return $this->read($this->table);
    }

    public function getUserByEmail($email) {
        $conditions = ['loginusuario' => $email];
        return $this->read($this->table, $conditions);
    }
        
     
    public function getUserById($id) {
        $conditions = ['idusuario' => $id];
        return $this->read($this->table, $conditions);
    }

    public function deleteUserById($id) {
        $conditions = ['idusuario' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createUser($data) {
          // Validação dos campos obrigatórios
          $requiredFields = ['IDUSUARIO', 'NOMEUSUARIO', 'LOGINUSUARIO', 'SENHAUSUARIO', 'NIVELUSUARIO'];
          foreach ($requiredFields as $field) {
              if (empty($data[$field])) {
                  return ['error' => "Field $field is required"];
              }
          }
        $fields = [
            'IDUSUARIO' => $data['IDUSUARIO'],
            'NOMEUSUARIO' => $data['NOMEUSUARIO'],
            'LOGINUSUARIO' => $data['LOGINUSUARIO'],
            'SENHAUSUARIO' => $data['SENHAUSUARIO'],
            'NIVELUSUARIO' => $data['NIVELUSUARIO']
        ];
        return $this->create($this->table, $fields);
    }

    public function updateUserById($data,$id) {
        $conditions = ['idusuario' => $id];
        $fields = [];
        if (!empty($data['NOMEUSUARIO'])) {
            $fields['NOMEUSUARIO'] = $data['NOMEUSUARIO'];
        }
        if (!empty($data['LOGINUSUARIO'])) {
            $fields['LOGINUSUARIO'] = $data['LOGINUSUARIO'];
        }
        if (!empty($data['SENHAUSUARIO'])) {
            $fields['SENHAUSUARIO'] = $data['SENHAUSUARIO'];
        }
        if (!empty($data['NIVELUSUARIO'])) {
            $fields['NIVELUSUARIO'] = $data['NIVELUSUARIO'];
        }

        if (empty($fields)) {
            return ['error' => 'No fields to update'];
        }
        return  $this->update($this->table, $fields,$conditions);
     }
}