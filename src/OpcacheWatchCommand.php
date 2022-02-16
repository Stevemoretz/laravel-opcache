<?php

namespace SteveMoretz\LaravelOpcacheClear;

use Crypt;
use Illuminate\Console\Command;
use Spatie\Watcher\Watch;

class OpcacheWatchCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "opcache:watch";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Clear OpCache";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Watch::path(__DIR__)
             ->onFileUpdated(function (string $newFilePath) {
                 dd($newFilePath);
             })->start();
    }
}
