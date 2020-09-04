<?php
namespace App\Repositories;
use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Models\Transaction;

class TransactionsRepository implements TransactionsRepositoryInterface {
    public function getTransactions(int $offset,string $search,string $role,string $order){
        //los paso a minusculas para asegurarme de no perder resultados
        //tengo que hacer un middleware para hacer todo esto minusculas
        /* $loweredSearch = strtolower($search);
        $loweredRole = strtolower($role);
        $loweredOrder = strtolower($order);
        $query = Transaction::whereRaw('lower(name) like (?) and lower(role) = (?)',["%{$loweredSearch}%","{$loweredRole}"]);
        //si el orden es por fecha, quiero que sea descendiente
        $orderedQuery = $loweredOrder === 'updated_at' ? $query->orderBy($loweredOrder,'desc') : $query->orderBy($loweredOrder);
        $count = $query->count(); */
        return "Hello"/* ['result'=>$orderedQuery->skip($offset)->take(10)->get(),'count'=>$count] */;
    }

    public function getTransactionsMinified(){
        return ['result'=>Transaction::select('contact_id as value','name')->get()];
    }

    public function searchTransactions(string $search){
        $loweredString = strtolower($search);
        return Transaction::whereRaw('lower(name) like (?)',["%{$loweredString}%"])->take(10)->get();
    }

    public function getTransactionById(int $id){
        return Transaction::find($id);
    }

    public function deleteTransactionById(int $id){
        return Transaction::destroy($id);
    }

    public function postTransaction(string $name, string $phone, string $role, float $money, string $address){
        return Transaction::create(['name'=>$name,'phone'=>$phone,'role'=>$role,'money'=>$money,'address'=>$address]);
    }

    public function updateTransaction(string $name,string $phone,string $address,float $money,int $id){
        $Transaction = Transaction::find($id);
        $Transaction->name = $name;
        $Transaction->phone = $phone;
        $Transaction->address = $address;
        $Transaction->money = $money;
        return $Transaction->save();
    }
}