<?php

namespace App\Console\Commands;

use App\User;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all users to elasticsearch';

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

        $this->info('Indexing all users. Might take a while...');
        /** @var User $user */
        foreach (User::cursor() as $user) {
            $this->client->index([
                'index' => $user->getSearchIndex(),
                'type' => $user->getSearchType(),
                'id' => $user->id,
                'body' => $user->toSearchArray(),
            ]);
            // PHPUnit-style feedback
            $this->output->write('.');
        }
        $this->info("\nDone!");
    }
}
