# Pedidos [/orders]
Representación del recurso de pedidos.

## Obtener Pedidos. [GET /orders/{search?,type?,completed?,delivered?,order?,offset?}]
Filtrados por nombre de contacto, compleción, entregados, tipo (entrante o saliente) ('a' o 'b', respectivamente) y offset.
Ordenados por suma, fecha de creación o fecha de actualización.
El límite está programado a 10.
Los parámetros pueden ser enviados por querystring o por json.

+ Parameters
    + search (string, optional) - Buscar por descripción del gasto.
        + Default: String vacío
    + completed ('completed'|'not_completed'|'all', optional) - Filtrar por compleción.
        + Default: all
    + delivered ('delivered'|'not_delivered'|'all', optional) - Filtrar por entregados.
        + Default: all
    + order ('created_at'|'updated_at', optional) - Define la columna utilizada para ordenar los resultados. No está utilizado en el front
        + Default: created_at
    + offset (integer, optional) - Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.
        + Default: 0

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "search": "Patricio",
                "role": "c",
                "order": "name",
                "offset": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "result": [
                    {
                        "order_id": "integer",
                        "contact_id": "integer",
                        "completed": "boolean",
                        "delivered": "boolean",
                        "type": "'a'|'b'",
                        "paid": "float",
                        "sum": "float",
                        "products_count": "integer",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null",
                        "contact": {
                            "name": "string",
                            "address": "string",
                            "phone": "string",
                            "contact_id": "integer"
                        }
                    }
                ],
                "count": "integer"
            }

## Obtener pedido específico. [GET /orders/id/{id}]
Obtener una representación JSON de un pedido por su ID.
"current_version" solo aparece si el producto en el pedido está desactualizado.

+ Parameters
    + id (integer, required) - ID del pedido.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "order_id": "integer",
                "contact_id": "integer",
                "completed": "boolean",
                "delivered": "boolean",
                "type": "'a'|'b'",
                "paid": "float",
                "sum": "float",
                "created_at": "timestamp",
                "updated_at": "timestamp",
                "deleted_at": "null",
                "contact": {
                    "name": "string",
                    "address": "string",
                    "phone": "string",
                    "contact_id": "integer"
                },
                "products": [
                    {
                        "ammount": "integer",
                        "delivered": "boolean",
                        "product_id": "integer",
                        "product_history_id": "integer",
                        "current_version": {
                            "product_id": "integer",
                            "product_history_id": "integer",
                            "name": "string",
                            "sell_price": "float",
                            "buy_price": "float"
                        },
                        "product_version": {
                            "product_id": "integer",
                            "product_history_id": "integer",
                            "name": "string",
                            "sell_price": "integer",
                            "buy_price": "integer"
                        }
                    }
                ],
                "transactions": [
                    {
                        "transaction_id": "integer",
                        "sum": "integer",
                        "created_at": "timestamp"
                    }
                ]
            }

## Obtener productos de un pedido específico. [GET /orders/id/products/{id}]
Obtener una representación JSON de los productos de un pedido por su ID.
"current_version" solo aparece si el producto en el pedido está desactualizado.

+ Parameters
    + id (integer, required) - ID del pedido.

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
                        "ammount": "integer",
                        "delivered": "boolean",
                        "product_id": "integer",
                        "product_history_id": "integer",
                        "current_version": {
                            "product_id": "integer",
                            "product_history_id": "integer",
                            "name": "string",
                            "sell_price": "float",
                            "buy_price": "float"
                        },
                        "product_version": {
                            "product_id": "integer",
                            "product_history_id": "integer",
                            "name": "string",
                            "sell_price": "integer",
                            "buy_price": "integer"
                        }
                    }
                ]
            }

## Eliminar un pedido. [DELETE /orders/orders]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer"
            }

## Crear un pedido. [POST /orders]
La variable type define si el pedido es una compra (a), o una venta (b).

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "contact_id": "integer",
                "type": "'a'|'b'"
            }

## Actualizar un pedido. [PUT /orders]
La variable type define si el pedido es una compra (a), o una venta (b).

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "contact_id": "integer",
                "type": "'a'|'b'"
            }

## Agregar un producto a un pedido. [POST /orders/products]
Los productos no pueden estar repetidos en un pedido, si se intenta agregar un producto ya existente, devuelve error de validación.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "product_id": "integer",
                "ammount": "integer"
            }

## Modificar un producto de un pedido. [PUT /orders/products]
Los productos no pueden estar repetidos en un pedido, si se intenta cambiar a un producto ya existente, devuelve error de validación.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "product_id": "integer",
                "ammount": "integer",
                "delivered": "integer"
            }

## Remover un producto de un pedido. [DELETE /orders/products]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "product_id": "integer"
            }

## Definir cantidad de entregados de un producto en un pedido. [POST /orders/products/delivered]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "product_id": "integer",
                "ammount": "integer"
            }

## Definir cantidad de entregados de varios productos en un pedido al mismo tiempo. [POST /orders/products/delivered]
- falta poder validar el maximo de productos que podes entregar en base a la cantidad de stock, para no quedar en números negativos

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer",
                "products": [
                    {
                        "product_id": "integer",
                        "ammount": "integer"
                    }
                ]
            }

## Agregar una transacción a un pedido. [POST /orders/transactions]
- debería pasar este endpoint al recurso "transacciones"

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "transaction_id": "integer",
                "sum": "float"
            }

## Modificar una transacción de un pedido. [PUT /orders/transactions]
- debería pasar este endpoint al recurso "transacciones"

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "transaction_id": "integer",
                "sum": "float"
            }

## Eliminar una transacción de un pedido. [DELETE /orders/transactions]
- debería pasar este endpoint al recurso "transacciones"

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "transaction_id": "integer"
            }

## Marcar pedido como completado. [POST /orders/completed]
Cambia el booleano "completed" de false a true

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "order_id": "integer"
            }
