<?php

namespace App\Services;

use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Repositories\OrdersRepositoryInterface;

class OrdersService implements OrdersServiceInterface
{
    private $repo;

    public function __construct(OrdersRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getOrders(string $search, string $completed, string $delivered, string $order, string $type, int $offset)
    {
        return $this->repo->getOrders($search, $completed, $delivered, $order, $type, $offset);
    }
    public function getOrderById(int $order_id)
    {
        return $this->repo->getOrderById($order_id);
    }
    public function getOrderProductsByOrderId(int $order_id)
    {
        return $this->repo->getOrderProductsByOrderId($order_id);
    }
    public function deleteOrderById(int $order_id)
    {
        return $this->repo->deleteOrderById($order_id);
    }
    public function postOrder(int $contact_id, string $type)
    {
        return $this->repo->postOrder($contact_id, $type);
    }
    public function updateOrder(int $order_id, int $contact_id, string $type)
    {
        return $this->repo->updateOrder($order_id, $contact_id, $type);
    }
    public function addOrderProduct(int $order_id, int $product_id, int $ammount)
    {
        return $this->repo->addOrderProduct($order_id, $product_id, $ammount);
    }
    public function modifyOrderProduct(int $order_id, int $product_id, int $ammount, int $delivered)
    {
        return $this->repo->modifyOrderProduct($order_id, $product_id, $ammount, $delivered);
    }
    public function removeOrderProduct(int $order_id, int $product_id)
    {
        return $this->repo->removeOrderProduct($order_id, $product_id);
    }
    public function markDelivered(int $order_id, int $product_id, int $ammount)
    {
        return $this->repo->markDelivered($order_id, $product_id, $ammount);
    }
    public function markDeliveredMultiple(int $order_id, array $products)
    {
        return $this->repo->markDeliveredMultiple($order_id, $products);
    }
    public function getTransactions(string $search, string $order, string $type, int $offset)
    {
        return $this->repo->getTransactions($search, $order, $type, $offset);
    }
    public function addTransaction(int $order_id, float $sum)
    {
        return $this->repo->addTransaction($order_id, $sum);
    }
    public function modifyTransaction(int $transaction_id, float $sum)
    {
        return $this->repo->modifyTransaction($transaction_id, $sum);
    }
    public function deleteTransaction(int $transaction_id)
    {
        return $this->repo->deleteTransaction($transaction_id);
    }
    public function markCompleted(int $order_id)
    {
        return $this->repo->markCompleted($order_id);
    }
    public function getOrderTicketPDF(int $order_id)
    {
        //ESTO DEBERIA HACER UNA CONSULTA PERSONALIZADA A LA BASE DE DATOS, PARA NO OBTENER TODOS LOS DATOS DE FORMA INNECESARIA, PERO POR AHORA FUNCIONA
        $order = $this->repo->getOrderById($order_id);
        $orderProducts = $order["products"];

        $ticket = array_map(function ($product) {
            //TYPECASTING MOLESTO PORQUE PHP PIERDE EL TIPO OBJECT
            $productInTicket = (object)[];
            $objProduct = (object)$product;
            $productVersion = $objProduct->product_version;
            $objProductVersion = (object)$productVersion;
            $productInTicket->name = $objProductVersion->name;
            $productInTicket->price = $objProductVersion->sell_price;
            $productInTicket->ammount = $objProduct->ammount;
            $productInTicket->total_value = $objProduct->ammount * $objProductVersion->sell_price;
            return $productInTicket;
        }, $orderProducts->toArray());

        $sum = $order["sum"];

        $contact = $order["contact"];

        $date = date('d/m/Y', strtotime($order["order"]["created_at"]));

        $pdf = app('dompdf.wrapper')->setPaper('a5', 'landscape')->loadView('orderProducts', ['ticket' => $ticket, 'sum' => $sum, 'contact' => $contact, 'date'=>$date]);

        return $pdf->stream($contact->name.'-'.$date.'.pdf');

        return $ticket;
    }
}
