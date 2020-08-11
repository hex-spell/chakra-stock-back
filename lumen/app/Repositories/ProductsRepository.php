<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductsRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductsRepository implements ProductsRepositoryInterface
{
  public function getProducts(string $search, string $order, int $category_id, int $offset)
  {
    return "hello";
  }
  public function getProductCategories()
  {
    return "hello";
  }
  public function searchProducts()
  {
    return "hello";
  }
  public function getProductById()
  {
    return "hello";
  }
  public function deleteProductById(int $product_id)
  {
    return "hello";
  }
  public function postProduct(string $description, float $sum, int $category_id)
  {
    return "hello";
  }
  public function updateProduct(string $description, float $sum, int $product_id, int $category_id)
  {
    return "hello";
  }
  public function postProductCategory(string $name)
  {
    return "hello";
  }
  public function updateProductCategory(string $name, int $category_id)
  {
    return "hello";
  }
  public function deleteProductCategoryById(int $category_id)
  {
    return "hello";
  }
}
