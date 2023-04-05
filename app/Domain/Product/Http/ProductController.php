<?php

declare(strict_types=1);

namespace App\Domain\Product\Http;

use App\Domain\Product\ProductDTO;
use App\Domain\Product\ProductService;
use App\Domain\Shared\Controller;
use App\Core\Exceptions\BadRequestException;
use App\Core\Response\Response;
use stdClass;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        return Response::make()
                       ->changeContent($this->service->getAllProducts());
    }

    public function show($id): Response
    {
        return Response::make()
                       ->changeContent($this->service->getById($id) ?? new stdClass());
    }

    public function store(): Response
    {
        $dto = ProductDTO::fromRequest($_POST);

        $product = $this->service->create($dto);

        return Response::make()
                       ->changeContent($product);
    }

    public function delete($id): Response
    {
        if(!$this->service->delete($id)) {
            throw new BadRequestException("Nothing deleted");
        }

        return Response::make();
    }

    public function bulkDelete(): Response
    {
        if(empty($_GET) || !isset($_GET['ids'])) {
            throw new BadRequestException('You must include an \'?ids=...\' parameter to your request');
        }

        $count = $this->service->bulkDelete($_GET['ids']);

        if(!$count){
            throw new BadRequestException("Nothing deleted");
        }

        return Response::make()
                       ->changeContent([
                           'count' => $count
                       ]);
    }
}
