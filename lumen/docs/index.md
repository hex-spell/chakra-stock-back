FORMAT: 1A

# PHPStockREST

# Users [/users]
Representación del recurso de usuarios.

## Mostrar todos los usuarios. [GET /users]
Obtener una representación JSON de todos los usuarios en la base de datos.

+ Response 200 (application/json)
    + Body

            {
                "response": [
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

+ Request (application/x-www-form-urlencoded)
    + Body

            id=integer

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


+ Request (application/x-www-form-urlencoded)
    + Body

            id=integer

# Contacts [/contacts]
Representación del recurso de contactos.

## Mostrar los contactos filtrados por nombre, rol y offset. Ordenados por nombre, rol, fecha de creación, fecha de actualización o deuda. [GET /contacts]
El límite está programado a 10.
Los roles son "c" para los clientes y "p" para los proveedores

+ Request (application/x-www-form-urlencoded)
    + Headers

            Authorization: Bearer {token}
    + Body

            search=string&role=c|p&order=name|created_at|updated_at|money&offset=integer

+ Response 200 (application/json)
    + Body

            {
                "response": [
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