<?php

namespace App\DTO\Request\Profile;

class ProfileResponse
{
    public int $id;
    public string $phone;
    public string $gender;
    public string $address;
    public int $user_id;

    public function __construct(array $user)
    {
        $this->id = $user["id"] ?? "";
        $this->phone = $user["phone"] ?? "";
        $this->gender = $user["gender"] ?? "";
        $this->address = $user["address"] ?? "";
        $this->user_id = $user["user_id"] ?? 0;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'address' => $this->address,
            'user_id' => $this->user_id,
        ];
    }
}
