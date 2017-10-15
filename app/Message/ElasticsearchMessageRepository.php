<?php

namespace App\Message;

use App\Message;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchMessageRepository implements MessageRepository
{
    private $search;

    public function __construct(Client $client) {
        $this->search = $client;
    }

    public function search(string $query = ""): Collection {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query): array {
        $instance = new Message;

        $items = $this->search->search([
            'index' => $instance->getSearchIndex(),
            'type' => $instance->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['message'],
                        'query' => $query
                    ],                  
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items): Collection {

        $hits = array_pluck($items['hits']['hits'], '_source') ?: [];

        $sources = array_map(function ($source) {
            return $source;
        }, $hits);



        // We have to convert the results array into Eloquent Models.
        return Message::hydrate($sources);
    }
}