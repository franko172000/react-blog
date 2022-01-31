<?php

namespace App\Console\Commands;

use App\Business\Services\ExternalPostService;
use App\Persistence\Repositories\PostRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PullExternalPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'external-post:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull customer post from external endpoint';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info("Pull started...");
        resolve(ExternalPostService::class)->pullPosts();
        $this->info("Pull completed...");
    }
}
