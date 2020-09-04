<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Models\Transaction;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    public function getTransactions(int $offset, string $search, string $type)
    {
        //los paso a minusculas para asegurarme de no perder resultados
        //tengo que hacer un middleware para hacer todo esto minusculas
        //('lower(contact.name) like (?) and lower(orderType) = (?)', ["%{$loweredSearch}%", "{$loweredType}"]);
        $loweredSearch = strtolower($search);
        $loweredType = strtolower($type);

        $query = Transaction::
        with('contact:name,contact_id')
        ->with('order:type,order_id')
        ->whereHas('contact', function ($query) use ($loweredSearch) {
            return $query->whereRaw('lower(name) like (?)', ["%{$loweredSearch}%"]);
        })
        ->whereHas('order', function ($query) use ($loweredType) {
            return $query->whereRaw('lower(type) like (?)', ["%{$loweredType}%"]);
        });

        //si el orden es por fecha, quiero que sea descendiente
        $count = $query->count();
        return ['result' => $query->orderBy('created_at','desc')->skip($offset)->take(10)->get(), 'count' => $count];
    }

    public function getTransactionsMinified()
    {
        return ['result' => Transaction::select('contact_id as value', 'name')->get()];
    }

    public function searchTransactions(string $search)
    {
        $loweredString = strtolower($search);
        return Transaction::whereRaw('lower(name) like (?)', ["%{$loweredString}%"])->take(10)->get();
    }

    public function getTransactionById(int $id)
    {
        return Transaction::find($id);
    }

    public function deleteTransactionById(int $id)
    {
        return Transaction::destroy($id);
    }

    public function postTransaction(string $name, string $phone, string $role, float $money, string $address)
    {
        return Transaction::create(['name' => $name, 'phone' => $phone, 'role' => $role, 'money' => $money, 'address' => $address]);
    }

    public function updateTransaction(string $name, string $phone, string $address, float $money, int $id)
    {
        $Transaction = Transaction::find($id);
        $Transaction->name = $name;
        $Transaction->phone = $phone;
        $Transaction->address = $address;
        $Transaction->money = $money;
        return $Transaction->save();
    }
}
