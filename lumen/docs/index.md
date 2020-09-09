FORMAT: 1A

# PHPStockREST

# Users [/users]
Representación del recurso de usuarios.

## Mostrar todos los usuarios. [GET /users]
Obtener una representación JSON de todos los usuarios en la base de datos.

## Obtener usuario específico. [GET /users/id/{id}]
Obtener una representación JSON de un usuario por su ID.

+ Request (application/x-www-form-urlencoded)
    + Body

            id=integer

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