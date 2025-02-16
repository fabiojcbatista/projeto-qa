<?php
date_default_timezone_set('America/Sao_Paulo');
$data=date("y-m-d H:i:s");
//require_once("conexao.php");
require_once __DIR__ . '/../config/database.php';

class DatabaseHandler {
    private $db;

    public function __construct() {
       $database = new Database();
       $this->db = $database->connect();
    }

    // Função para criar registros (Insert)
    public function create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = mysqli_prepare($this->link, $sql);
        
        if (!$stmt) {
            return ['error' => 'Failed to prepare query'];
        }

        // Bind parameters
        $types = str_repeat("s", count($data)); // Assuming all data is strings
        mysqli_stmt_bind_param($stmt, $types, ...array_values($data));
        
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => 'Record inserted successfully'];
        }
        
        return ['error' => 'Insert failed'];
    }
        
    // Função para ler registros (Select)
    public function read($table, $conditions = [], $columns = '*') {
        //global $link;
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
        return ['error' => 'Erro na consulta: ' . mysqli_error($dataBase)];
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
        $where = implode(" AND ", array_map(function($k) { return "$k = ?"; }, array_keys($conditions)));

        $sql = "DELETE FROM $table WHERE $where";
        $stmt = mysqli_prepare($this->link, $sql);

        if (!$stmt) {
            return ['error' => 'Failed to prepare query'];
        }

        $params = array_values($conditions);
        $types = str_repeat("s", count($params));

        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            return ['success' => 'Record deleted successfully'];
        }

        return ['error' => 'Delete failed'];
    }
}
