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
        $order = $request->get('order') ? $request->get('order') : "description";
        $category_id = $request->get('category_id') ? $request->get('category_id') : 0; //si es 0, que obtenga todas las categorias
        $offset = $request->get('offset') ? $offset = $request->get('offset') : 0;
        return $this->service->getProducts($search, $order, $category_id, $offset);
    }

    public function getProductCategories()
    {
        return $this->service->getProductCategories();
    }

    public function searchProducts()
    {
        return $this->service->searchProducts();
    }

    public function getProductById()
    {
        return $this->service->getProductById();
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
                'description' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:product_categories,category_id',
                'sum' => 'required|numeric',
            ]
        );
        $description = $request->get('description');
        $sum = $request->get('sum');
        $category_id = $request->get('category_id');
        return $this->service->postProduct($description, $sum, $category_id);
    }

    public function updateProduct(Request $request)
    {
        $this->validate(
            $request,
            [
                'description' => 'required|string|between:4,30',
                'category_id' => 'required|integer|exists:product_categories,category_id',
                'product_id' => 'required|integer|exists:products,product_id',
                'sum' => 'required|numeric',
            ]
        );
        $description = $request->get('description');
        $sum = $request->get('sum');
        $category_id = $request->get('category_id');
        $product_id = $request->get('product_id');
        return $this->service->updateProduct($description, $sum, $product_id, $category_id);
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

