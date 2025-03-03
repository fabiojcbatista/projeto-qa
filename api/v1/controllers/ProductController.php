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
        $result = $this->productModel->deleteProductById($productId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o produto', 500);
        }
        return $this->response(['message' => 'Produto deletado com sucesso'], 204);
    }

    public function createProduct($data) {
        $product = $this->productModel->createProduct($data);
        if (isset($product['error'])) {
            return $this->responseFail('Erro ao criar o produto', 500);
        }
        return $this->response(new ProductDTO($product), 201);
    }

    public function updateProductById($productId, $data) {
        $product = $this->productModel->updateProductById($data, $productId);
        if (isset($product['error'])) {
            return $this->responseFail('Erro ao atualizar o produto', 500);
        }
        $productDTOs = array_map(function($productData) {
            return (new ProductDTO($productData))->toArray();
        }, $product);
        return $this->response($productDTOs, 200);
    }
}
?>