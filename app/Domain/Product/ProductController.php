<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Helpers\Controller;

class ProductController extends Controller
{
    public function index(): void
    {
        echo 'index index';
    }

    public function show($id): void
    {
        echo "show {$id}";
    }

    public function store(): void
    {
        echo 'dsdssdssdsd';
    }

    public function delete(): void
    {
        echo 'dsdssdssdsd';
    }
}
