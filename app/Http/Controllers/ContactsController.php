<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ContactsServiceInterface;
use Illuminate\Http\Request;

/**
 * Representación del recurso de contactos.
 *
 * @Resource("Contactos", uri="/contacts")
 */
class ContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(ContactsServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Obtener contactos. 
     * Filtrados por nombre, rol y offset.
     * Ordenados por nombre, rol, fecha de creación, fecha de actualización o deuda.
     * El límite está programado a 10.
     * Los roles son "c" para los clientes y "p" para los proveedores
     * Los parámetros pueden ser enviados por querystring o por json.
     * 
     * @Get("{search?,role?,order?,offset?}")
     * @Request({"search":"Patricio", "role":"c", "order":"name", "offset":"0"},headers={"Authorization": "Bearer {token}"})
     * @Parameters({
     *      @Parameter("search", type="string", required=false, description="Buscar por nombre de contacto.", default="String vacío"),
     *      @Parameter("role", type="'c'|'p'", required=false, description="Filtrar por cliente o proveedor.", default="c"),
     *      @Parameter("order", type="'name'|'created_at'|'updated_at'|'money'", required=false, description="Define la columna utilizada para ordenar los resultados.", default="name"),
     *      @Parameter("offset", type="integer", required=false, description="Cantidad de resultados a saltear, recomendable ir de 10 en 10, ya que el límite está definido en 10.", default=0)
     *  })
     * @Response(200, body={"result":{{"contact_id": "integer", "address": "string", "name": "string", "phone": "string", "money": "float", "created_at": "timestamp", "updated_at": "timestamp", "deleted_at": "null"}}, "count":"integer"})
     */
    public function getContacts(Request $request)
    {
        //saca los 4 parametros de la url
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        $search = $request->get('search') ? $request->get('search') : '';
        //role es 'c' o 'p', clientes o proveedores respectivamente
        //por default quiero que devuelva clientes
        //deberia buscar una forma de validar 'role' para que solamente pueda ser 'c' o 'p'
        $role = $request->get('role') ? $request->get('role') : 'c';
        $order = $request->get('order') ? $request->get('order') : 'name';
        //deberia preguntarle a alguien si esto se puede refactorizar, son demasiados parametros para una sola funcion
        return $this->service->getContacts($offset, $search, $role, $order);
    }

    /**
     * Obtener contactos minificados.
     * Retorna una lista de todos los contactos, sólamente con sus nombres e ID's.
     * Elegí el alias "value" para los ID's porque desde el frontend servía para usarlos en menús 'select'
     * 
     * @Get("/menu")
     * 
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"result":{{"value": "integer", "name": "string"}}, "count":"integer"})
     */
    public function getContactsMinified()
    {
        return $this->service->getContactsMinified();
    }

    /**
     * Obtener contacto específico.
     *
     * Obtener una representación JSON de un contacto por su ID.
     *
     * @Get("/id/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del contacto.")
     * })
     * @Request({},headers={"Authorization": "Bearer {token}"})
     * @Response(200, body={"user_id": "integer", "email": "string", "name": "string"})
     */
    public function getContactById(int $id)
    {
        return $this->service->getContactById($id);
    }

    /**
     * Crear un nuevo contacto.
     * 
     * @Post("/")
     * @Request({"name": "string", "phone": "string", "address": "string", "role": "'c'|'p'"},headers={"Authorization": "Bearer {token}"})
     */
    public function postContact(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'phone' => 'required|digits_between:4,30|numeric|unique:contacts,phone',
                'address' => 'required|string|between:4,30',
                'role' => 'required|string|size:1',
                'money' => 'required|numeric'
            ]
        );
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $role = $request->get('role');
        $money = $request->get('money');
        return $this->service->postContact($name, $phone, $role, $money, $address);
    }

    /**
     * Actualizar contacto.
     * 
     * @Put("/")
     * @Request({"contact_id":"integer", "name": "string", "phone": "string", "address": "string", "role": "'c'|'p'"},headers={"Authorization": "Bearer {token}"})
     */
    public function updateContact(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|between:4,30',
                'address' => 'required|string|between:4,30',
                'contact_id' => 'required|integer|exists:contacts,contact_id',
                'money' => 'required|numeric',
                'phone' => 'required|numeric|unique:contacts,phone,'
                    . $request->get('contact_id') .
                    ',contact_id'
            ]
        );
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $money = $request->get('money');
        $id = $request->get('contact_id');
        return $this->service->updateContact($name, $phone, $address, $money, $id);
    }

    /**
     * Eliminar contacto.
     * 
     * @Delete("/")
     * @Request({"contact_id":"integer"},headers={"Authorization": "Bearer {token}"})
     */
    public function deleteContactById(Request $request)
    {
        $this->validate($request, [
            'contact_id' => 'required|exists:contacts,contact_id'
        ]);
        $id = $request->get('contact_id');
        return $this->service->deleteContactById($id);
    }
}
