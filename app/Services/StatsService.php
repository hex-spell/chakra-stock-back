<?php

namespace App\Services;

use App\Interfaces\Repositories\ContactsRepositoryInterface;
use App\Interfaces\Repositories\ExpensesRepositoryInterface;
use App\Interfaces\Repositories\OrdersRepositoryInterface;
use App\Interfaces\Repositories\TransactionsRepositoryInterface;
use App\Interfaces\Services\StatsServiceInterface;
use App\Interfaces\Services\TransactionsServiceInterface;
use Carbon\Carbon;

class StatsService implements StatsServiceInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $ordersRepo;
    private $expensesRepo;
    private $transactionsRepo;
    private $contactsRepo;

    public function __construct(OrdersRepositoryInterface $ordersRepo, ExpensesRepositoryInterface $expensesRepo, TransactionsRepositoryInterface $transactionsRepo, ContactsRepositoryInterface $contactsRepo)
    {
        $this->ordersRepo = $ordersRepo;
        $this->expensesRepo = $expensesRepo;
        $this->transactionsRepo = $transactionsRepo;
        $this->contactsRepo = $contactsRepo;
    }

    public function getStats()
    {
        //a veces las consultas retornan strings en vez de numeros, por eso le agregué el typecasting feo este
        $pendingOrdersCount = $this->ordersRepo->getPendingOrdersCount();
        $expensesSum = (float)$this->expensesRepo->getExpensesSum();
        $transactionsInSum = (float)$this->transactionsRepo->getTransactionsSum('b');
        $transactionsOutSum = (float)$this->transactionsRepo->getTransactionsSum('a');
        $benefits = $transactionsInSum - $transactionsOutSum - $expensesSum;
        $contactsDebt = (float)$this->contactsRepo->getContactsDebt();
        $ownDebt = (float)$this->contactsRepo->getOwnDebt();
        return ['pending_orders'=>$pendingOrdersCount, 'expenses_sum'=>$expensesSum, 'transactions_in'=>$transactionsInSum, 'transactions_out'=>$transactionsOutSum, 'benefits'=>$benefits, 'contacts_debt'=>$contactsDebt, 'own_debt'=>$ownDebt];
    }


}
