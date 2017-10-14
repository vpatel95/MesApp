<?php

namespace App\Message;

use Illuminate\Database\Eloquent\Collection;

interface MessageRepository {

    public function search(string $query = "", int $chat_id_search): Collection;

}