<?php

namespace App\Interfaces\Repositories;

interface ProductsRepositoryInterface
{
    public function getProducts(string $search, string $order, int $category_id, int $offset);
    public function getProductCategories();
    public function searchProducts();
    public function getProductById();
    public function deleteProductById(int $product_id);
    public function postProduct(string $description, float $sum, int $category_id);
    public function updateProduct(string $description, float $sum, int $product_id, int $category_id);
    public function postProductCategory(string $name);
    public function updateProductCategory(string $name, int $category_id);
    public function deleteProductCategoryById(int $category_id);
}
