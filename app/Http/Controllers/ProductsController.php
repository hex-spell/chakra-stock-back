<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ProductsServiceInterface;
use Illuminate\Http\Request;

/**
 * Representación del recurso de productos.
 *
 * @Resource("Productos", uri="/products")
 */
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

    /**
     * Obtener productos. 
     * Filtrados por nombre, categoría y offset.
     * Ordenados por nombre, precio de venta, precio de compra, fecha de creación o fecha de actualización.
     * El límite está programado a 10.
     * Los parámetros pueden ser enviados por querystring o por json.
     * 
     * @Get("{search?,category_id,order?,offset?}")
     * @Request({"search":"Arróz", "category_id":1, "order":"name", "offset":"0"},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("search", type="string", required=false, description="Buscar por nombre del producto.", default="String vacío"),
     *      @Parameter("category_id", type="integer", required=true, description="Filtrar por categoría. 0 obtiene de todas las categorías", default=0),
     *      @Parameter("order", type="'name'|'created_at'|'updated_at'|'buy_price'|'sell_price'", required=false, description="Define la columna utilizada para ordenar los resultados.", default="name"),
     *      @Parameter("offset", type="integer", required=false, description="Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.", default=0)
     *  })
     * @Response(200, body={"result":
     *      {
     *          {
     *              "product_id": "integer",
     *              "product_history_id": "integer",
     *              "category_id": "integer",
     *              "name": "string",
     *              "sell_price": "float", 
     *              "buy_price": "float",
     *              "stock": "integer",
     *              "created_at": "timestamp", 
     *              "updated_at": "timestamp", 
     *              "deleted_at": "null"
     *          }
     *      }, 
     *      "count":"integer"
     *      }
     * )
     */
    public function getProducts(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "stock";
        $category_id = $request->get('category_id') ? $request->get('category_id') : 0; //si es 0, que obtenga todas las categorias
        $offset = $request->get('offset') ? $offset = $request->get('offset') : 0;
        return $this->service->getProducts($search, $order, $category_id, $offset);
    }

    /**
     * Obtener categorías.
     * Retorna una lista de todas las categorías de los productos.
     * 
     * @Get("/categories")
     * 
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":{{"category_id": "integer", "name": "string"}}, "count":"integer"})
     */
    public function getProductCategories()
    {
        return $this->service->getProductCategories();
    }

    /**
     * Obtener lista de productos.
     * Retorna una lista de todos los productos sin timestamps, en el frontend la uso para un menú 'select'.
     * 
     * @Get("/list")
     * 
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":
     *      {
     *          {
     *              "product_id": "integer",
     *              "product_history_id": "integer",
     *              "category_id": "integer",
     *              "name": "string",
     *              "sell_price": "float", 
     *              "buy_price": "float",
     *              "stock": "integer"
     *          }
     *      }, 
     *      "count":"integer"
     *      }
     * )
     */
    public function getProductsList()
    {
        return $this->service->getProductsList();
    }

    public function getProductsPDF()
    {
        return $this->service->getProductsPDF();
    }

    /**
     * Obtener un producto específico.
     * Retorna un producto en base al id pasado por uri.
     * - El formato está raro porque en realidad no he usado este endpoint.
     * 
     * @Get("/id/{id}")
     * 
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del producto")
     *  })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":
     *      {
     *          "product": {
     *              "product_id": "integer",
     *              "product_history_id": "integer",
     *              "category_id": "integer",
     *              "name": "string",
     *              "sell_price": "float", 
     *              "buy_price": "float",
     *              "stock": "integer"
     *          }
     *      }
     *      }
     * )
     */
    public function getProductById(int $id)
    {
        return $this->service->getProductById($id);
    }

    /**
     * Eliminar un producto.
     * 
     * @Delete("/")
     * @Request({"product_id": "integer"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Crear un producto.
     * 
     * @Post("/")
     * @Request({"category_id": "integer","name": "string", "stock": "integer", "sell_price": "float", "buy_price": "float"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Actualizar un producto.
     * 
     * @Put("/")
     * @Request({"product_id":"integer", "category_id": "integer", "name": "string", "stock": "integer", "sell_price": "float", "buy_price": "float"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Actualizar el stock de un producto.
     * - 'ammount' resta o suma, no asigna.
     * 
     * @Put("/stock")
     * @Request({"product_id":"integer","ammount":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function updateProductStock(Request $request){
        $this->validate($request,[
            'product_id' => 'required|exists:products,product_id',
            'ammount' => 'required|integer'
        ]);
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        return $this->service->updateProductStock($product_id,$ammount);
    }

    /**
     * Crear una categoría de productos.
     * 
     * @Post("/categories")
     * @Request({"name": "string"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Actualizar una categoría de productos.
     * 
     * @Put("/categories")
     * @Request({"category_id":"integer", "name": "string"},headers={"Authorization": "Bearer {token}"})
     */
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

    /**
     * Eliminar una categoría de productos.
     * 
     * @Delete("/categories")
     * @Request({"category_id":"integer"},headers={"Authorization": "Bearer {token}"})
     */
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

