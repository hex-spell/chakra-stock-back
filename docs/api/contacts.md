# Contactos [/contacts]
Representación del recurso de contactos.

## Obtener contactos. [GET /contacts/{search?,role?,order?,offset?}]
- Filtrados por nombre, rol y offset.
- Ordenados por nombre, rol, fecha de creación, fecha de actualización o deuda.
- El límite está programado a 10.
- Los roles son "c" para los clientes y "p" para los proveedores
- Los parámetros pueden ser enviados por querystring o por json.

+ Parameters
    + search (string, optional) - Buscar por nombre de contacto.
        + Default: String vacío
    + role ('c'|'p', optional) - Filtrar por cliente o proveedor.
        + Default: c
    + order ('name'|'created_at'|'updated_at'|'money', optional) - Define la columna utilizada para ordenar los resultados.
        + Default: name
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
                        "contact_id": "integer",
                        "address": "string",
                        "name": "string",
                        "phone": "string",
                        "money": "float",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null"
                    }
                ],
                "count": "integer"
            }

## Obtener contactos minificados. [GET /contacts/menu]
- Retorna una lista de todos los contactos, sólamente con sus nombres e ID's.
- Elegí el alias "value" para los ID's porque desde el frontend servía para usarlos en menús 'select'

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
                        "value": "integer",
                        "name": "string"
                    }
                ],
                "count": "integer"
            }

## Obtener contacto específico. [GET /contacts/id/{id}]
Obtener una representación JSON de un contacto por su ID.

+ Parameters
    + id (integer, required) - ID del contacto.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "contact_id": "integer",
                "address": "string",
                "name": "string",
                "phone": "string",
                "money": "float",
                "created_at": "timestamp",
                "updated_at": "timestamp",
                "deleted_at": "null"
            }

## Crear un nuevo contacto. [POST /contacts]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "string",
                "phone": "string",
                "address": "string",
                "role": "'c'|'p'"
            }

## Actualizar contacto. [PUT /contacts]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "contact_id": "integer",
                "name": "string",
                "phone": "string",
                "address": "string",
                "role": "'c'|'p'"
            }

## Eliminar contacto. [DELETE /contacts]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "contact_id": "integer"
            }