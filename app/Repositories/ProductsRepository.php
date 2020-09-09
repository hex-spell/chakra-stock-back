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

    $query = $category_id ? ProductCategory::findOrFail($category_id)->products() :
      Product::select('*');

    //esto es confuso, pero funciona
    $filteredQuery = $query->select('product_history.*', 'products.product_id', 'products.stock', 'products.category_id', 'products.product_history_id')->leftJoin('product_history', function ($query) {
      $query->on('products.product_id', '=', 'product_history.product_id')
        ->whereRaw('product_history.product_history_id IN (select MAX(a2.product_history_id) from product_history as a2 join products as u2 on u2.product_id = a2.product_id group by u2.product_id)');;
    })->whereRaw($whereRaw[0], $whereRaw[1]);

    //si el orden es por fecha o por stock, se cambia la orientacion
    $orderedQuery = $loweredOrder === 'updated_at' || $loweredOrder === 'stock' ?
      $filteredQuery->orderBy($loweredOrder, 'desc') :
      $filteredQuery->orderBy($loweredOrder);

    $count = $filteredQuery->count();
    return ['result' => $orderedQuery->skip($offset)->take(10)->get(), 'count' => $count];
  }
  public function getProductCategories()
  {
    return ['result' => ProductCategory::all()];
  }
  //esto esta al pedo, pero como funciona no lo saco, por ahora
  public function getProductsList()
  {
    //obtiene lista minificada de productos
    $Products = Product::with('current')->get();
    $ProductsList = [];
    foreach ($Products as $product) {
      array_push(
        $ProductsList,
        (object)[
          'name' => $product->current->name,
          'sell_price' => $product->current->sell_price,
          'buy_price' => $product->current->buy_price,
          'stock' => $product->stock,
          'product_id' => $product->product_id,
          'category_id' => $product->category_id
        ]
      );
    }
    return ['result' => $ProductsList, 'count' => $Products->count()];
  }
  public function getProductById(int $product_id)
  {
    return Product::find($product_id);
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
  public function updateProductStock(int $product_id, int $ammount)
  {
    $Product = Product::find($product_id);
    $Product->stock += $ammount;
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
