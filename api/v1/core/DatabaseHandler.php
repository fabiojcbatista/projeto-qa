<?php
date_default_timezone_set('America/Sao_Paulo');
$data=date("y-m-d H:i:s");
require_once __DIR__ . '/../config/database.php';

class DatabaseHandler {
    private $db;

    public function __construct() {
       $database = new Database();
       $this->db = $database->connect();
    }

    public function create($table, $data) {
        $dataBase =$this->db;
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_map([$this, 'quoteValue'], array_values($data)));
       
        
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = mysqli_query($dataBase, $sql);

        if (!$result) {
            return ['error' => 'Insert fail: ' . mysqli_error($dataBase)];
        }
       
        return $data;
    }

    protected function quoteValue($value) {
        return "'" . mysqli_real_escape_string($this->db, $value) . "'";
    }

    // Função para ler registros (Select)
    public function read($table, $conditions = [], $columns = '*') {
        $where = '';
        $params = [];
        $types = '';
        $dataBase =$this->db;
       
        if (!empty($conditions)) {
            $where = 'WHERE ' . implode(' AND ', array_map(function($k, $v) use ($dataBase) {
                return "$k = '" . mysqli_real_escape_string($dataBase, $v) . "'";
            }, array_keys($conditions), $conditions));
        }

        $sql = "SELECT $columns FROM $table $where";
        $result = mysqli_query($dataBase, $sql);

    if (!$result) {
        return ['error' => 'Select fail: ' . mysqli_error($dataBase)];
    }

    $data = [];
   while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
   
    return $data;
}
    

    // Função para atualizar registros (Update)
    public function update($table, $data, $conditions) {
        $set = implode(", ", array_map(function($k) { return "$k = ?"; }, array_keys($data)));
        $where = implode(" AND ", array_map(function($k) { return "$k = ?"; }, array_keys($conditions)));
        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = mysqli_prepare($this->link, $sql);

        if (!$stmt) {
            return ['error' => 'Failed to prepare query'];
        }

        $params = array_merge(array_values($data), array_values($conditions));
        $types = str_repeat("s", count($params));

        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            return ['success' => 'Record updated successfully'];
        }

        return ['error' => 'Update failed'];
    }

    // Função para deletar registros (Delete)
    public function delete($table, $conditions) {
        $where = '';
        $params = [];
        $types = '';
        $dataBase =$this->db;
       
        if (!empty($conditions)) {
            $where = 'WHERE ' . implode(' AND ', array_map(function($k, $v) use ($dataBase) {
                return "$k = '" . mysqli_real_escape_string($dataBase, $v) . "'";
            }, array_keys($conditions), $conditions));
        }

        $sql = "DELETE FROM $table $where";
        $result = mysqli_query($dataBase, $sql);

    if (!$result) {
        return ['error' => 'Delete fail: ' . mysqli_error($dataBase)];
    }

    $data = [];
   while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
   
    return $data;
    }
}
