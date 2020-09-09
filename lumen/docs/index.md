FORMAT: 1A

# PHPStockREST

# Users [/users]
Representación del recurso de usuarios.

## Mostrar todos los usuarios. [GET /users]
Obtener una representación JSON de todos los usuarios en la base de datos.

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
                        "user_id": "integer",
                        "email": "string",
                        "name": "string"
                    }
                ],
                "count": "integer"
            }

## Obtener usuario específico. [GET /users/id/{id}]
Obtener una representación JSON de un usuario por su ID.

+ Parameters
    + id (integer, required) - ID del usuario.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

+ Response 200 (application/json)
    + Body

            {
                "user_id": "integer",
                "email": "string",
                "name": "string"
            }

## Crear un nuevo usuario. [POST /users]


+ Request (application/json)
    + Body

            {
                "name": "string",
                "password": "string",
                "email": "email"
            }

## Actualizar nombre de usuario. [PUT /users/updatename]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "name": "string"
            }

## Actualizar contraseña. [PUT /users/updatepassword]


+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            {
                "password": "string"
            }

## Eliminar usuario. [DELETE /users/{id}]


+ Parameters
    + id (integer, required) - ID del usuario.

+ Request (application/json)
    + Headers

            Authorization: Bearer {token}
    + Body

            []

# Contactos [/contacts]
Representación del recurso de contactos.

## Obtener contactos. [GET /contacts/{search?,role?,order?,offset?}]
Filtrados por nombre, rol y offset.
Ordenados por nombre, rol, fecha de creación, fecha de actualización o deuda.
El límite está programado a 10.
Los roles son "c" para los clientes y "p" para los proveedores
Los parámetros pueden ser enviados por querystring o por json.

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
                        "money": "integer",
                        "created_at": "timestamp",
                        "updated_at": "timestamp",
                        "deleted_at": "null"
                    }
                ],
                "count": "integer"
            }

## Obtener contactos minificados. [GET /contacts/menu]
Retorna una lista de todos los contactos, sólamente con sus nombres e ID's.
Elegí el alias "value" para los ID's porque desde el frontend servía para usarlos en menús <select>

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