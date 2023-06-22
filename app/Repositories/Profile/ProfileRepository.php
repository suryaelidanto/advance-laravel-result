<?php

namespace App\Repositories\Profile;

interface ProfileRepository
{
    public function getProfileById(int $id): array;
}
