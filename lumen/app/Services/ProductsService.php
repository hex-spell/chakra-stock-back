<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductsRepositoryInterface;
use App\Interfaces\Services\ProductsServiceInterface;

class ProductsService implements ProductsServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    public function __construct(ProductsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getProducts(string $search, string $order, int $category_id, int $offset)
    {
        return $this->repo->getProducts($search, $order, $category_id, $offset);
    }

    public function getProductCategories()
    {
        return $this->repo->getProductCategories();
    }

    public function searchProducts()
    {
        return $this->repo->searchProducts();
    }

    public function getProductById()
    {
        return $this->repo->getProductById();
    }

    public function deleteProductById(int $product_id)
    {
        return $this->repo->deleteProductById($product_id);
    }

    public function postProduct(string $description, float $sum, int $category_id)
    {
        return $this->repo->postProduct($description, $sum, $category_id);
    }

    public function updateProduct(string $description, float $sum, int $product_id, int $category_id)
    {
        return $this->repo->updateProduct($description, $sum, $product_id, $category_id);
    }

    public function postProductCategory(string $name)
    {
        return $this->repo->postProductCategory($name);
    }

    public function updateProductCategory(string $name, int $category_id)
    {
        return $this->repo->updateProductCategory($name, $category_id);
    }

    public function deleteProductCategoryById(int $category_id)
    {
        return $this->repo->deleteProductCategoryById($category_id);
    }
}
