<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $offset = $request->get('offset') ? $request->get('offset') : 0;
        return $this->service->getOrders($search, $order, $type, $offset);
    }
    public function searchOrders()
    {
        return $this->service->searchOrders();
    }
    public function getOrderById(Request $request)
    {
        $this->validate($request, ['order_id' => 'required|numeric|exists:orders,order_id']);
        $order_id = $request->get('order_id');
        return $this->service->getOrderById($order_id);
    }
    public function deleteOrderById(int $order_id)
    {
        return $this->service->deleteOrderById($order_id);
    }
    public function postOrder(Request $request)
    {
        //los tipos son A o B
        $this->validate(
            $request,
            [
                'contact_id' => 'required|numeric|exists:contacts,contact_id',
                'type' => 'required|string|size:1',
            ]
        );
        $contact_id = $request->get('contact_id');
        $type = $request->get('type');
        return $this->service->postOrder($contact_id, $type);
    }
    public function updateOrder(Request $request)
    {
        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:orders,order_id',
                'contact_id' => 'required|numeric|exists:contacts,contact_id',
                'type' => 'required|string|size:1',
            ]
        );
        $order_id = $request->get('order_id');
        $contact_id = $request->get('contact_id');
        $type = $request->get('type');
        return $this->service->updateOrder($order_id, $contact_id, $type);
    }
    public function addOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exists:orders,order_id|unique:order_products,order_id,NULL,id,product_id,' . $product_id,
                'product_id' => 'required|numeric|exists:products,product_id|unique:order_products,product_id,NULL,id,order_id,' . $order_id,
                'ammount' => 'required|integer',
            ]
        );
        return $this->service->addOrderProduct($order_id, $product_id, $ammount);
    }
    public function modifyOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        $this->validate(
            $request,
            [
                'order_id' => [
                    'required',
                    'numeric',
                    Rule::exists('order_products')->where(function ($query) use ($product_id) {
                        $query->where('product_id', $product_id);
                    })
                ],
                'product_id' => [
                    'required',
                    'numeric',
                    Rule::exists('order_products')->where(function ($query) use ($order_id) {
                        $query->where('order_id', $order_id);
                    })
                ],
                'ammount' => 'required|integer',
            ]
        );
        return $this->service->modifyOrderProduct($order_id, $product_id, $ammount);
    }
    public function removeOrderProduct(Request $request)
    {
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');

        $this->validate(
            $request,
            [
                'order_id' => 'required|numeric|exist:order_products,order_id',
                'product_id' => 'required|numeric|exists:order_products,product_id'
            ]
        );
        return $this->service->removeOrderProduct($order_id, $product_id);
    }
    public function markDelivered(Request $request)
    {

        $product_id = $request->get('product_id');
        $ammount = $request->get('ammount');
        return $this->service->markDelivered($product_id, $ammount);
    }
    public function getTransactions(Request $request)
    {
        $order_id = $request->get('order_id') ? $request->get('order_id') : 0;
        return $this->service->getTransactions($order_id);
    }
    public function addTransaction(Request $request)
    {
        $sum = $request->get('sum');
        return $this->service->addTransaction($sum);
    }
    public function modifyTransaction(Request $request)
    {
        $transaction_id = $request->get('transaction_id');
        $sum = $request->get('sum');
        return $this->service->modifyTransaction($transaction_id, $sum);
    }
    public function markCompleted(Request $request)
    {
        $order_id = $request->get('order_id');
        return $this->service->markCompleted($order_id);
    }
}
