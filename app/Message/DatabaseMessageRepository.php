<?php

namespace App\Message;

use App\Message;
use Illuminate\Database\Eloquent\Collection;

class DatabaseMessageRepository implements MessageRepository {

    public function search(string $query = "", int $chat_id_search): Collection {

        return Message::where('message', 'like', "%{$query}%")->where('chat_id',$chat_id_search)->get();

    }
}
