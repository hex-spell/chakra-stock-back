<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\Services\OrdersServiceInterface;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $service;

    public function __construct(OrdersServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getOrders(Request $request)
    {
        $search = $request->get('search') ? $request->get('search') : "";
        $order = $request->get('order') ? $request->get('order') : "";
        $type = $request->get('type') ? $request->get('type') : "";
        $offset = $request->get('offset') ? $request->get('offset') : "";
        return $this->service->getOrders($search, $order, $type, $offset);
    }
    public function searchOrders()
    {
        return $this->service->searchOrders();
    }
    public function getOrderById()
    {
        return $this->service->getOrderById();
    }
    public function deleteOrderById(int $order_id)
    {
        return $this->service->deleteOrderById($order_id);
    }
    public function postOrder(Request $request)
    {
        $contact_id = $request->get('contact_$contact_id') ? $request->get('contact_$contact_id') : "";
        $type = $request->get('type') ? $request->get('type') : "";
        return $this->service->postOrder($contact_id, $type);
    }
    public function updateOrder(Request $request)
    {
        $contact_id = $request->get('contact_$contact_id') ? $request->get('contact_$contact_id') : "";
        $type = $request->get('type') ? $request->get('type') : "";
        return $this->service->updateOrder($contact_id, $type);
    }
    public function addOrderProduct(Request $request)
    {
        $product_id = $request->get('product_id') ? $request->get('product_id') : "";
        $product_history_id = $request->get('product_history_id') ? $request->get('product_history_id') : "";
        $ammount = $request->get('ammount') ? $request->get('ammount') : "";
        return $this->service->addOrderProduct($product_id, $product_history_id, $ammount);
    }
    public function modifyOrderProduct(Request $request)
    {
        $product_id = $request->get('product_id') ? $request->get('product_id') : "";
        $product_history_id = $request->get('product_history_id') ? $request->get('product_history_id') : "";
        $ammount = $request->get('ammount') ? $request->get('ammount') : "";
        return $this->service->modifyOrderProduct($product_id, $product_history_id, $ammount);
    }
    public function markDelivered(Request $request)
    {
        $product_id = $request->get('product_id') ? $request->get('product_id') : "";
        $ammount = $request->get('ammount') ? $request->get('ammount') : "";
        return $this->service->markDelivered($product_id, $ammount);
    }
    public function getTransactions(Request $request)
    {
        $order_id = $request->get('order_id') ? $request->get('order_id') : "";
        return $this->service->getTransactions($order_id);
    }
    public function addTransaction(Request $request)
    {
        $sum = $request->get('sum') ? $request->get('sum') : "";
        return $this->service->addTransaction($sum);
    }
    public function modifyTransaction(Request $request)
    {
        $transaction_id = $request->get('transaction_id') ? $request->get('transaction_id') : "";
        $sum = $request->get('sum') ? $request->get('sum') : "";
        return $this->service->modifyTransaction($transaction_id, $sum);
    }
    public function markCompleted(Request $request)
    {
        $order_id = $request->get('order_id') ? $request->get('order_id') : "";
        return $this->service->markCompleted($order_id);
    }
}
