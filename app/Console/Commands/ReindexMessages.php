<?php

namespace App\Console\Commands;

use App\Message;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex:messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all messages to elasticsearch';

    /**
     * The elastic search client variable
     *
     * @var \Elasticsearch\Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(Client $client) {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $this->info('Indexing all messages. Might take a while...');
        /** @var Message $message */
        foreach (Message::cursor() as $message) {
            $this->client->index([
                'index' => $message->getSearchIndex(),
                'type' => $message->getSearchType(),
                'id' => $message->id,
                'body' => $message->toSearchArray(),
            ]);
            // PHPUnit-style feedback
            $this->output->write('.');
        }
        $this->info("\nDone!");
    }
}
