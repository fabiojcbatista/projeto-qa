<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../dto/ProductDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';
header('Content-Type: application/json');

class ProductController extends ResponseHelper {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new Product($db);
    }

    public function getProducts() {
        $products = $this->productModel->getProducts();
        if (empty($products)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $productDTOs = array_map(function($productData) {
            return (new ProductDTO($productData))->toArray();
        }, $products);
        return $this->response($productDTOs, 200);
    }
   
    public function getProductById($productId) {
        $products = $this->productModel->getProductById($productId);
        if (empty($products)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $productDTOs = array_map(function($productData) {
            return (new ProductDTO($productData));
        }, $products);
        return $this->response($productDTOs, 200);
    }

    public function createProduct($data) {
        return $this->productModel->create($data);
    }
}