<?php

namespace App\Users;

use App\User;
use Illuminate\Database\Eloquent\Collection;

class DatabaseUserRepository implements UserRepository {

    public function search(string $query = ""): Collection {

        return User::where('name', 'like', "%{$query}%")->get();

    }
}