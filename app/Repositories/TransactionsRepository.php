<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionsRepository implements TransactionsRepositoryInterface
{
    public function getTransactions(int $offset, string $search, string $type)
    {
        //los paso a minusculas para asegurarme de no perder resultados
        //tengo que hacer un middleware para hacer todo esto minusculas
        $loweredSearch = strtolower($search);
        $loweredType = strtolower($type);

        //aca tengo que agregar orders.completed para definir desde el frontend si se puede modificar o no la transaccion
        $query = Transaction::select('transactions.*', 'contacts.name', 'orders.type')
            ->leftJoin('orders', 'transactions.order_id', '=', 'orders.order_id')
            ->leftJoin('contacts', 'transactions.contact_id', '=', 'contacts.contact_id')
            ->whereRaw('lower(name) like ? and lower(type) = ?', ["%{$loweredSearch}%", "{$loweredType}"]);

        $count = $query->count();
        return ['result' => $query->orderBy('created_at', 'desc')->skip($offset)->take(10)->get(), 'count' => $count];
    }

    public function getTransactionsMinified()
    {
        return ['result' => Transaction::select('contact_id as value', 'name')->get()];
    }

    public function getTransactionById(int $id)
    {
        return Transaction::find($id);
    }

    public function deleteTransactionById(int $transaction_id)
    {
        return Transaction::find($transaction_id)->destroy();
    }

    public function postTransaction(string $name, string $phone, string $role, float $money, string $address)
    {
        return Transaction::create(['name' => $name, 'phone' => $phone, 'role' => $role, 'money' => $money, 'address' => $address]);
    }

    public function updateTransaction(int $transaction_id, float $sum)
    {
        $Transaction = Transaction::find($transaction_id);
        $Transaction->sum = $sum;
        return $Transaction->save();
    }

    public function getTransactionsSum(string $type)
    {
        //tipos son a o b, viene de los pedidos
        return Transaction::orderBy('transactions.created_at', 'DESC')           
            ->leftJoin('orders', 'transactions.order_id', '=', 'orders.order_id')
            ->whereDate('orders.created_at', '>', Carbon::now()->subMonth())
            ->where('type', '=', $type)->sum('transactions.sum');
    }
}
