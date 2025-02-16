<?php
require_once 'BaseModel.php';
header('Content-Type: application/json');

date_default_timezone_set('America/Sao_Paulo');
$data = date("y-m-d H:i:s");

class Product extends BaseModel {
    protected $table = 'product';

    public function getProducts() {
        return $this->read($this->table);
    }

    public function getProductByName($nome) {
        $conditions = ['nmproduto' => $nome];
        return $this->read($this->table, $conditions);
    }
        
     
    public function getProductById($id) {
        $conditions = ['codProduto' => $id];
        return $this->read($this->table, $conditions);
    }
}