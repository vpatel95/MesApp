<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Collection;

interface UserRepository {

    public function search(string $query = ""): Collection;

}