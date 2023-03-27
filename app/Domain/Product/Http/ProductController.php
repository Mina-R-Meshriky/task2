<?php

declare(strict_types=1);

namespace App\Domain\Product\Http;

use App\Domain\Product\ProductService;
use App\Helpers\Controller;
use App\Helpers\Response\Response;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service) {
        $this->service = $service;
    }

    public function index(): Response
    {
        return Response::make()
            ->changeContent($this->service->getAllProducts());
    }

    public function show($id): Response
    {
       //  todo
    }

    public function store(): void
    {
        //  todo
    }

    public function delete($id): void
    {
        //  todo
    }
}
