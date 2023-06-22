<?php

namespace App\DTO\Request\Product;

use Illuminate\Support\Facades\Validator;

class ProductRequest
{
    public string $name;
    public string $desc;
    public int $price;
    public string $image;
    public int $qty;
    public int $seller_id;
    public array $category_id;

    public function __construct(array $user)
    {
        $this->name = $user["name"] ?? "";
        $this->desc = $user["desc"] ?? "";
        $this->price = $user["price"] ?? 0;
        $this->image = $user["image"] ?? "";
        $this->qty = $user["qty"] ?? 0;
        $this->seller_id = $user["seller_id"] ?? 0;
        $this->category_id = $user["category_id"] ?? [];
    }

    public function validate(): array
    {
        $validator = Validator::make([
            'name' => $this->name,
            'desc' => $this->desc,
            'price' => $this->price,
            'image' => $this->image,
            'qty' => $this->qty,
            'seller_id' => $this->seller_id,
            'category_id' => $this->category_id,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'desc' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'string'],
            'qty' => ['required', 'integer', 'min:1'],
            'seller_id' => ['required', 'integer'],
            'category_id' => ['required', 'array'],
            'category_id.*' => ['integer'], // this rule validates each element of the array
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return [
                'error' => $errors,
            ];
        }

        return [];
    }
}
