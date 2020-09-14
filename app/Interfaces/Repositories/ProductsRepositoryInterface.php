<?php

namespace App\Interfaces\Repositories;

interface ProductsRepositoryInterface
{
    public function getProducts(string $search, string $order, int $category_id, int $offset);
    public function getProductCategories();
    public function getProductsList();
    public function getProductsListGroupedByCategories();
    public function getProductById(int $product_id);
    public function deleteProductById(int $product_id);
    public function postProduct(string $name, float $sell, float $buy, int $stock, int $category_id);
    public function updateProduct(string $name, float $sell, float $buy, int $stock,int $product_id, int $category_id);
    public function updateProductStock(int $product_id, int $ammount);
    public function postProductCategory(string $name);
    public function updateProductCategory(string $name, int $category_id);
    public function deleteProductCategoryById(int $category_id);
}
