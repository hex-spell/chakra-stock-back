# Gastos [/expenses]
Representación del recurso de gastos.

## Obtener gastos. [GET /expenses/{search?,category_id,order?,offset?}]
- Filtrados por descripción, categoría y offset.
- Ordenados por descripción, suma, fecha de creación o fecha de actualización.
- El límite está programado a 10.
- Los parámetros pueden ser enviados por querystring o por json.

+ Parameters
    + search (string, optional) - Buscar por descripción del gasto.
        + Default: String vacío
    + category_id (integer, optional) - Filtrar por categoría. 0 obtiene de todas las categorías
        + Default: 0
    + order ('description'|'created_at'|'updated_at'|'sum', optional) - Define la columna utilizada para ordenar los resultados.
        + Default: name
    + offset (integer, optional) - Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.
        + Default: 0

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "search": "Factura ejemplo",
                "order": "description",
                "category_id": "1",
                "offset": "0"
            }

+ Response 200 (application/json)
    + Body

            {
                "result": [
                    {
                        "expense_id": "integer",
                        "category_id": "integer",
                        "description": "string",
                        "sum": "float",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null"
                    }
                ],
                "count": "integer"
            }

## Obtener categorías. [GET /expenses/categories]
Retorna una lista de todas las categorías de los gastos.

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

## Crear una categoría. [POST /expenses/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "string"
            }

## Actualizar una categoría. [PUT /expenses/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "string",
                "category_id": "integer"
            }

## Eliminar una categoría. [DELETE /expenses/categories]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer"
            }

## Postear un gasto. [POST /expenses]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer",
                "name": "string",
                "description": "string",
                "sum": "float"
            }

## Actualizar un gasto. [PUT /expenses]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "category_id": "integer",
                "expense_id": "integer",
                "name": "string",
                "description": "string",
                "sum": "float"
            }

## Eliminar gasto. [DELETE /expenses]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "expense_id": "integer"
            }
