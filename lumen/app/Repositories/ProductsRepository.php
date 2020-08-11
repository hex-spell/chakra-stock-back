<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductsRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductHistory;

class ProductsRepository implements ProductsRepositoryInterface
{
  public function getProducts(string $search, string $order, int $category_id, int $offset)
  {
    return "hello";
  }
  public function getProductCategories()
  {
    return ProductCategory::all();
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
  public function postProduct(string $name, float $sell, float $buy, int $stock, int $category_id)
  {
    return ProductHistory::create(['name' => $name, 'sell_price' => $sell, 'buy_price' => $buy])->currentProduct()->create(['category_id' => $category_id, 'stock' => $stock]);
  }
  public function updateProduct(string $name, float $sell, float $buy, int $stock, int $product_id, int $category_id)
  {
    ProductHistory::create(['name' => $name, 'sell_price' => $sell, 'buy_price' => $buy, 'product_id' => $product_id]);
    $Product = Product::find($product_id);
    $Product->category_id = $category_id;
    $Product->stock = $stock;
    return $Product->save();
  }
  public function postProductCategory(string $name)
  {
    return ProductCategory::create(['name' => $name]);
  }
  public function updateProductCategory(string $name, int $category_id)
  {
    $Category = ProductCategory::find($category_id);
    $Category->name = $name;
    return $Category->save();
  }
  public function deleteProductCategoryById(int $category_id)
  {
    return ProductCategory::destroy($category_id);
  }
}
