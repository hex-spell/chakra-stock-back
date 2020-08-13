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
    $loweredSearch = strtolower($search);
    $loweredOrder = strtolower($order);
    //argumentos de la consulta
    $whereRaw = ['lower(name) like (?)', ["%{$loweredSearch}%"]];
    //si el category_id es 0 o nulo, se busca en todas las categorias

    $query = $category_id ? ProductCategory::findOrFail($category_id)->products()->with('current') :
      Product::with('current');


    $filteredQuery = $query->whereHas('current', function ($query) use ($whereRaw) {
      return $query->whereRaw($whereRaw[0], $whereRaw[1]);
    });

    //si el orden es por fecha o por stock, se cambia la orientacion
    $orderedQuery = $loweredOrder === 'updated_at' || $loweredOrder === 'stock' ?

      $filteredQuery->orderBy($loweredOrder, 'desc') :

      $filteredQuery->whereHas('current', function ($query) use ($loweredOrder) {
        return $query->orderBy($loweredOrder);
      });

    $count = $filteredQuery->count();
    return ['result' => $orderedQuery->skip($offset)->take(10)->get(), 'count' => $count];
  }
  public function getProductCategories()
  {
    return ['result' => ProductCategory::all()];
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
    return Product::destroy($product_id);
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
