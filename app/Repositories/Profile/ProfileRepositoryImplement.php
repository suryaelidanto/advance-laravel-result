<?php

namespace App\Repositories\Profile;

use App\Models\Profile;

class ProfileRepositoryImplement implements ProfileRepository
{
    private $model;

    public function __construct(Profile $model)
    {
        $this->model = $model;
    }

    public function getProfileById(int $id): array
    {
        try {
            $profile = $this->model->with("user")->find($id);

            if (empty($profile)) {
                return ["error" => "Profile not found"];
            }

            $profile = $profile->toArray();

            return $profile;
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
