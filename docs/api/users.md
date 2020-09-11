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
