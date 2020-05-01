# lumen-rest
this api was made to learn all lumen's features
## endpoints

### Users 

 - `POST /users` : add 1 user

 Provide name, email and password.

```json
{
    "name": "[string min 5]",
    "email": "[string min 5]",
    "password": "[string min 5]"
}
```
 - `PUT /users/updatename` : update username.

 Provide new name and access token.

```json
{
    "name": "[string min 5]",
    "token": "[string 60]"
}
```
 - `PUT /users/updatepassword` : update password.

 Provide new password and access token.

```json
{
    "password": "[string min 5]",
    "token": "[string 60]"
}
```

 - `POST /login` : get user access token

 Provide email and password.

```json
{
    "email": "[string min 5]",
    "password": "[string min 5]"
}
```
Response:
```json
{
    "token": "[string 60]"
}
```

### Contacts

Access token needed in every route.

 - `GET /contacts` : get 10 contacts
 - `GET /contacts/search/{search}` : get 10 contacts max that match `search`
 - `GET /contacts/id/{id}` : get 1 contact with given `id`
 - `DELETE /contacts/id/{id}` : delete 1 contact with given `id`
 - `POST /contacts` : add 1 contact

 Provide name and phone number.

```json
{
    "name": "[string min 5]",
    "phone": "[numeric string min 5]"
}
```
 - `PUT /contacts` : update 1 contact

 Provide name, phone number and id.

```json
{
    "name": "[string min 5]",
    "phone": "[numeric string min 5]",
    "id": "[int]"
}
```
