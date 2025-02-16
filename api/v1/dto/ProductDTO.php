<?php

class ProductDTO {
    public $codProduto;
    public $nmProduto;
    public $vlProduto;
    public $dtProduto;
    public $qtProduto;

    public function __construct($productData) {
        $this->codProduto = $productData['codProduto'] ?? null;
        $this->nmProduto = $productData['nmProduto'] ?? null;
        $this->vlProduto = $productData['vlProduto'] ?? null;
        $this->dtProduto = $productData['dtProduto'] ?? null;
        $this->qtProduto = $productData['qtProduto'] ?? null;
    }

    public function toArray() {
        return [
            'codProduto' => $this->codProduto,
            'nmProduto' => $this->nmProduto,
            'vlProduto' => $this->vlProduto,
            'dtProduto' => $this->dtProduto,
            'qtProduto' => $this->qtProduto
        ];
    }
}