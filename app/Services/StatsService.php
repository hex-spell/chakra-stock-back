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
        $pendingOrdersCount = $this->ordersRepo->getPendingOrdersCount();
        $expensesSum = $this->expensesRepo->getExpensesSum();
        $transactionsInSum = $this->transactionsRepo->getTransactionsSum('b');
        $transactionsOutSum = $this->transactionsRepo->getTransactionsSum('a');
        $benefits = $transactionsInSum - $transactionsOutSum - $expensesSum;
        $contactsDebt = $this->contactsRepo->getContactsDebt();
        $ownDebt = $this->contactsRepo->getOwnDebt();
        return ['pending_orders'=>$pendingOrdersCount, 'expenses_sum'=>$expensesSum, 'transactions_in'=>$transactionsInSum, 'transactions_out'=>$transactionsOutSum, 'benefits'=>$benefits, 'contacts_debt'=>$contactsDebt, 'own_debt'=>$ownDebt];
    }


}
