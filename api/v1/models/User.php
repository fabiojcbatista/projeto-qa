<?php
require_once 'BaseModel.php';
header('Content-Type: application/json');

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
}