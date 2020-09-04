<?php

namespace App\Services;

use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Interfaces\Services\TransactionsServiceInterface;

class TransactionsService implements TransactionsServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $repo;

    public function __construct(TransactionsRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getTransactions(int $offset,string $search,string $type)
    {
        return $this->repo->getTransactions($offset,$search,$type);
    }

    public function getTransactionsMinified()
    {
        return $this->repo->getTransactionsMinified();
    }

    public function searchTransactions(string $search)
    {
        return $this->repo->searchTransactions($search);
    }

    public function getTransactionById(int $id)
    {
        return $this->repo->getTransactionById($id);
    }

    public function deleteTransactionById(int $id)
    {
        return $this->repo->deleteTransactionById($id);
    }

    public function postTransaction(string $name, string $phone, string $role, float $money, string $address)
    {
        return $this->repo->postTransaction($name, $phone, $role, $money, $address);
    }

    public function updateTransaction(string $name,string $phone,string $address,float $money,int $id)
    {
        return $this->repo->updateTransaction($name,$phone,$address,$money,$id);
    }
}
