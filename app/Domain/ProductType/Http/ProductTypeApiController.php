<?php

namespace App\Domain\ProductType\Http;

use App\Core\Response\Response;
use App\Domain\ProductType\ProductTypeService;

class ProductTypeApiController
{

    private ProductTypeService $service;
    public function __construct(ProductTypeService $service) {
        $this->service = $service;
    }

    public function index()
    {
        return Response::make()
                       ->changeContent($this->service->all());
    }

}