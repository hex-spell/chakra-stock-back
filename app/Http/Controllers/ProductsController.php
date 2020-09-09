<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ProductsServiceInterface;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(ProductsServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getProducts(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "stock";
        $category_id = $request->get('category_id') ? $request->get('category_id') : 0; //si es 0, que obtenga todas las categorias
        $offset = $request->get('offset') ? $offset = $request->get('offset') : 0;
        return $this->service->getProducts($search, $order, $category_id, $offset);
    }

    public function getProductCategories()
    {
        return $this->service->getProductCategories();
    }

    public function getProductsList()
    {
        return $this->service->getProductsList();
    }


    public function getProductById(int $id)
    {
        return $this->service->getProductById($id);
    }

    public function deleteProductById(Request $request)
    {
        {
            $this->validate(
                $request,
                [
                    'product_id' => 'required|numeric|exists:products,product_id'
                ]
            );
            $product_id = $request->get('product_id');
            return $this->service->deleteProductById($product_id);
        }
    }

    public function postProduct(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:product_categories,category_id',
                'sell_price' => 'required|numeric',
                'buy_price' => 'required|numeric',
                'stock' => 'numeric'
            ]
        );
        $name = $request->get('name');
        $sell = $request->get('sell_price');
        $buy = $request->get('buy_price');
        $category_id = $request->get('category_id');
        $stock = $request->get('stock') ? $request->get('stock') : 0;
        return $this->service->postProduct($name, $sell, $buy, $stock, $category_id);
    }

    public function updateProduct(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:product_categories,category_id',
                'product_id' => 'required|integer|exists:products,product_id',
                'sell_price' => 'required|numeric',
                'buy_price' => 'required|numeric',
                'stock' => 'numeric'
            ]
        );
        $name = $request->get('name');
        $sell = $request->get('sell_price');
        $buy = $request->get('buy_price');
        $category_id = $request->get('category_id');
        $product_id = $request->get('product_id');
        $stock = $request->get('stock') ? $request->get('stock') : 0;
        return $this->service->updateProduct($name, $sell, $buy, $stock, $product_id, $category_id);
    }

    public function updateProductStock(Request $request){
        $this->validate($request,[
            'product_id' => 'required|exists:products,product_id',
            'ammount' => 'required|integer'
        ]);
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        return $this->service->updateProductStock($product_id,$ammount);
    }

    public function postProductCategory(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30|unique:product_categories,name',
            ]
        );
        $name = $request->get('name');
        return $this->service->postProductCategory($name);
    }

    public function updateProductCategory(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30|unique:product_categories,name,'
                    . $request->get('category_id') .
                    ',category_id',
                'category_id' => 'required|numeric|exists:product_categories,category_id'
            ]
        );
        $name = $request->get('name');
        $category_id = $request->get('category_id');
        return $this->service->updateProductCategory($name, $category_id);
    }

    public function deleteProductCategoryById(Request $request)
    {
        $this->validate(
            $request,
            [
                'category_id' => 'required|numeric|exists:product_categories,category_id'
            ]
        );
        $category_id = $request->get('category_id');
        return $this->service->deleteProductCategoryById($category_id);
    }
}

