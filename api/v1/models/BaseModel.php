<?php
require_once __DIR__ . '/../core/DatabaseHandler.php';

class BaseModel {
    protected $dbHandler;

    public function __construct($db) {
        if (!$db) {
            throw new Exception("Erro: Conexão com o banco de dados não fornecida.");
        }
        $this->dbHandler = new DatabaseHandler($db);
    }

    public function create($table, $data) {
        return $this->dbHandler->create($table, $data);
    }

    public function read($table, $conditions = [], $columns = '*') {  
        return $this->dbHandler->read($table, $conditions);
    }

    public function update($table, $data, $conditions) {
        return $this->dbHandler->update($table, $data, $conditions);
    }

    public function delete($table, $conditions) {
        return $this->dbHandler->delete($table, $conditions);
    }
}
