<?php

namespace App\Message;

use App\Message;
use Illuminate\Database\Eloquent\Collection;

class DatabaseMessageRepository implements MessageRepository {

    public function search(string $query = ""): Collection {

        return Message::where('message', 'like', "%{$query}%")->get();

    }
}
