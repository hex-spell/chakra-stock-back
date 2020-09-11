# Productos [/products]
Representación del recurso de productos.

## Obtener productos. [GET /products/{search?,category_id,order?,offset?}]
- Filtrados por nombre, categoría y offset.
- Ordenados por nombre, precio de venta, precio de compra, fecha de creación o fecha de actualización.
- El límite está programado a 10.
- Los parámetros pueden ser enviados por querystring o por json.

+ Parameters
    + search (string, optional) - Buscar por nombre del producto.
        + Default: String vacío
    + category_id (integer, required) - Filtrar por categoría. 0 obtiene de todas las categorías
        + Default: 0
    + order ('name'|'created_at'|'updated_at'|'buy_price'|'sell_price', optional) - Define la columna utilizada para ordenar los resultados.
        + Default: name
    + offset (integer, optional) - Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.
        + Default: 0

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "search": "Arróz",
                "category_id": 1,
                "order": "name",
                "offset": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "result": [
                    {
                        "product_id": "integer",
                        "product_history_id": "integer",
                        "category_id": "integer",
                        "name": "string",
                        "sell_price": "float",
                        "buy_price": "float",
                        "stock": "integer",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null"
                    }
                ],
                "count": "integer"
            }

## Obtener categorías. [GET /products/categories]
Retorna una lista de todas las categorías de los productos.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "result": [
                    {
                        "category_id": "integer",
                        "name": "string"
                    }
                ],
                "count": "integer"
            }

## Obtener lista de productos. [GET /products/list]
Retorna una lista de todos los productos sin timestamps, en el frontend la uso para un menú 'select'.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "result": [
                    {
                        "product_id": "integer",
                        "product_history_id": "integer",
                        "category_id": "integer",
                        "name": "string",
                        "sell_price": "float",
                        "buy_price": "float",
                        "stock": "integer"
                    }
                ],
                "count": "integer"
            }

## Obtener un producto específico. [GET /products/id/{id}]
Retorna un producto en base al id pasado por uri.
- El formato está raro porque en realidad no he usado este endpoint.

+ Parameters
    + id (integer, required) - ID del producto

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "result": {
                    "product": {
                        "product_id": "integer",
                        "product_history_id": "integer",
                        "category_id": "integer",
                        "name": "string",
                        "sell_price": "float",
                        "buy_price": "float",
                        "stock": "integer"
                    }
                }
            }

## Eliminar un producto. [DELETE /products]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "product_id": "integer"
            }

## Crear un producto. [POST /products]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer",
                "name": "string",
                "stock": "integer",
                "sell_price": "float",
                "buy_price": "float"
            }

## Actualizar un producto. [PUT /products]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "product_id": "integer",
                "category_id": "integer",
                "name": "string",
                "stock": "integer",
                "sell_price": "float",
                "buy_price": "float"
            }

## Actualizar el stock de un producto. [PUT /products/stock]
- 'ammount' resta o suma, no asigna.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "product_id": "integer",
                "ammount": "integer"
            }

## Crear una categoría de productos. [POST /products/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "string"
            }

## Actualizar una categoría de productos. [PUT /products/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer",
                "name": "string"
            }

## Eliminar una categoría de productos. [DELETE /products/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer"
            }
