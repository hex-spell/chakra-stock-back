# Transacciones [/transactions]
Representación del recurso de transacciones.

## Obtener transacciones. [GET /transactions/{search?,category_id,order?,offset?}]
- Filtrados por nombre de contacto, tipo de pedido (compra o venta) y offset.
- Ordenados por fecha de creación.
- El límite está programado a 10.
- Los parámetros pueden ser enviados por querystring o por json.
- 'name' es el nombre del contacto vinculado a la transacción.

+ Parameters
    + search (string, optional) - Buscar por nombre del contacto.
        + Default: String vacío
    + type ('a'|'b', required) - Filtrar por tipo de pedido al que está vinculada (compra o venta).
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
                        "transaction_id": "integer",
                        "order_id": "integer",
                        "contact_id": "integer",
                        "type": "'a'|'b'",
                        "description": "string",
                        "name": "string",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null"
                    }
                ],
                "count": "integer"
            }

## Eliminar una transacción de un pedido. [DELETE /transactions/transactions]
- debería pasar este endpoint al recurso "transacciones"

+ Parameters
    + transaction_id (integer, required) - ID de la transacción a eliminar

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

## Actualizar una transacción. [PUT /transactions]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "transaction_id": "integer",
                "sum": "float"
            }