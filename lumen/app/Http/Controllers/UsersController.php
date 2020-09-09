<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

/**
 * Representación del recurso de usuarios.
 *
 * @Resource("Users", uri="/users")
 */
class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $request;
    private $repo;

    public function __construct(Request $request, UsersRepositoryInterface $repo)
    {
        $this->request = $request;
        $this->repo = $repo;
    }

    private $validateUserName = ['name' => 'required|string|between:4,30'];

    private $validateUserPassword = ['name' => 'required|string|between:4,30'];

    private $validateAddUser = ['name' => 'required|string|between:4,30', 'email' => 'required|email|between:4,30|unique:users,email', 'password' => 'required|string|between:4,30'];

    /**
     * Mostrar todos los usuarios.
     *
     * Obtener una representación JSON de todos los usuarios en la base de datos.
     *
     * @Get("/")
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":{{"user_id": "integer", "email": "string", "name": "string"}}, "count":"integer"})
     */
    public function getUsers()
    {
        return User::all();
    }

    /**
     * Obtener usuario específico.
     *
     * Obtener una representación JSON de un usuario por su ID.
     *
     * @Get("/id/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del usuario.")
     * })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"user_id": "integer", "email": "string", "name": "string"})
     */
    public function getUserByID(int $id)
    {
        return User::find($id);
    }

    /**
     * Crear un nuevo usuario.
     * 
     * @Post("/")
     * @Request({"name": "string", "password": "string", "email": "email"})
     */
    public function addUser()
    {
        $this->validate($this->request, $this->validateAddUser);
        $name = $this->request->json()->get('name');
        $password = app('hash')->make($this->request->json()->get('password'));
        $email = $this->request->json()->get('email');
        return $this->repo->addUser($name, $password, $email);
    }

    /**
     * Actualizar nombre de usuario.
     * 
     * @Put("/updatename")
     * @Request({"name": "string"}, headers={"Authorization": "Bearer {token}"})
     */
    public function updateUserName()
    {
        $this->validate($this->request, $this->validateUserName);
        $name = $this->request->json()->get('name');
        $id = $this->request->auth->id;
        return $this->repo->updateUserName($name, $id);
    }

    /**
     * Actualizar contraseña.
     * 
     * @Put("/updatepassword")
     * @Request({"password": "string"}, headers={"Authorization": "Bearer {token}"})
     */
    public function updateUserPassword()
    {
        $this->validate($this->request, $this->validateUserPassword);
        $password = $this->request->json()->get('password');
        $id = $this->request->auth->id;
        return $this->repo->updateUserPassword($password, $id);
    }

    /**
     * Eliminar usuario.
     * 
     * @Delete("/{id}")
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del usuario.")
     * })
     */
    public function deleteUser(int $id)
    {
        //return $this->service->deleteUser($id);
    }
}
