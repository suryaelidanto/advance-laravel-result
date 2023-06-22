<?php

namespace App\Repositories\Product;

interface ProductRepository
{
    public function getAllProducts(): array;
    public function getProductById(int $id): array;
    public function createProduct(array $request): array;
}
