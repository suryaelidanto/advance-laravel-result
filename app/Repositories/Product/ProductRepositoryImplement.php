<?php

namespace App\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductRepositoryImplement implements ProductRepository
{
    private $model;
    private $modelCategory;

    public function __construct(Product $model, Category $modelCategory)
    {
        $this->model = $model;
        $this->modelCategory = $modelCategory;
    }

    public function getAllProducts(): array
    {
        try {
            $users = $this->model->with("productCategories")->with("seller")->get()->toArray();

            foreach ($users as &$user) { // & = reference operator
                $category_ids = [];
                foreach ($user["product_categories"] as $productCategory) {
                    $category_ids[] = $productCategory["category_id"];
                }

                $categories = $this->modelCategory->whereIn("id", $category_ids)->get()->toArray();
                $user["categories"] = $categories;
                unset($user["product_categories"]);
            }

            return $users;
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function getProductById(int $id): array
    {
        try {
            $user = $this->model->with('productCategories')->find($id);

            if (empty($user)) {
                return ["error" => "User not found"];
            }

            $user = $user->toArray();

            // getting category data from product
            $category_id = [];
            foreach ($user["product_categories"] as $productCategory) {
                $category_id[] = $productCategory["category_id"];
            }

            $category = $this->modelCategory->find($category_id);

            $user["category"] = $category;
            unset($user["product_categories"]);

            return $user;
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function createProduct(array $request): array
    {
        try {
            $name = $request["name"];
            $desc = $request["desc"];
            $price = $request["price"];
            $image = $request["image"];
            $qty = $request["qty"];
            $seller_id = $request["seller_id"];
            $category_id = $request["category_id"];

            $product = $this->model->create([
                "name" => $name,
                "desc" => $desc,
                "price" => $price,
                "image" => $image,
                "qty" => $qty,
                "seller_id" => $seller_id,
            ]);

            foreach ($category_id as $categoryId) {
                $productCategory = new ProductCategory();
                $productCategory->category_id = $categoryId;
                $product->productCategories()->save($productCategory);
            }

            return ["message" => sprintf("Product id : '%d' is created!", $product->id)];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
