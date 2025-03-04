<?php
require_once 'BaseModel.php';

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

    public function deleteProductById($id) {
        $conditions = ['codProduto' => $id];
        return $this->delete($this->table, $conditions);
    }

    public function createProduct($data) {
        $requiredFields = ['codProduto', 'nmProduto', 'vlProduto', 'dtProduto', 'qtProduto'];
foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return ['error' => "Field $field is required"];
            }
        }

        $fields = [
            'codProduto' => $data['codProduto'],
            'nmProduto' => $data['nmProduto'],
            'vlProduto' => $data['vlProduto'],
            'dtProduto' => $data['dtProduto'],
            'qtProduto' => $data['qtProduto']
        ];
        
        $result = $this->create($this->table, $fields);

        if (isset($result['error'])) {
            return ['error' => 'Failed to create product', 'details' => $result['error']];
        }

        return $result;
    }

    public function updateProductById($data,$id) {
        $conditions = ['codProduto' => $id];
        $fields = [];
        if (!empty($data['nmProduto'])) {
            $fields['nmProduto'] = $data['nmProduto'];
        }
        if (!empty($data['vlProduto'])) {
            $fields['vlProduto'] = $data['vlProduto'];
        }
        if (!empty($data['dtProduto'])) {
            $fields['dtProduto'] = $data['dtProduto'];
        }
        if (!empty($data['qtProduto'])) {
            $fields['qtProduto'] = $data['qtProduto'];
        }

        if (empty($fields)) {
            return ['error' => 'No fields to update'];
        }
        return  $this->update($this->table, $fields,$conditions);
     }
}