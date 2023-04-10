<?php

namespace App\Domain\Product\Http;


use App\Domain\Shared\Controller;

class ProductController extends Controller
{

    public function index()
    {
        require_once base_path('frontend/index.view.php');
        die;
    }

    public function create()
    {
        require_once base_path('frontend/create.view.php');
        die;
    }
}