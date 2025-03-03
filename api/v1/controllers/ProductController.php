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

    public function deleteProductById($productId) {
        $products = $this->productModel->deleteProductById($productId);
        return $this->responseFail('Not Content', 204);
    }

    public function createProduct($data) {
        $productModel = new Product($this->productModel);
        $product =  $productModel->createProduct($data);
        if (empty($product)) {
            return $this->responseFail('Nenhum registro criado', 404);
        }
        return $this->response(new ProductDTO($product), 201);
    }

    public function updateProductById($productId,$data) {
        $productModel = new Product($this->productModel);
        $product =  $productModel->updateProductById($data,$productId);
        if (empty($product)) {
            return $this->responseFail('Nenhum registro atualizado', 404);
        }
        $productDTOs = array_map(function($productData) {
            return (new ProductDTO($productData))->toArray();
        }, $product);
        return $this->response($productDTOs, 201);
    }
  }