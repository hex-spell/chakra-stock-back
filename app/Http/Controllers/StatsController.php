<?php
namespace App\Http\Controllers;
use App\Interfaces\Services\StatsServiceInterface;

class StatsController extends Controller {

    private $service;

    public function __construct(StatsServiceInterface $service)
    {
        $this->service = $service;
    }

    public function getStats()
    {
        return $this->service->getStats();
    }
}