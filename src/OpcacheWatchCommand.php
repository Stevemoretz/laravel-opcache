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
     *
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        Watch::paths(...config("opcache.watch_globs"))
             ->onFileUpdated(function (string $newFilePath) {
                 $originalToken = config("app.key");
                 $encryptedToken = Crypt::encrypt($originalToken);

                 $response = \Http::get(
                     config("opcache.base_url", "http://localhost") . "/opcache-clear",
                     [
                         "token" => $encryptedToken,
                         "update_file" => $newFilePath
                     ]
                 )->json();


                 if ($response["result"]) {
                     $this->line("File cache updated!");
                 }else {
                     if ($response["reason"]) {
                         $this->error($response["reason"]);
                     } else {
                         $this->error("Unexpected error!");
                     }
                 }
             })->setIntervalTime(500)->start();
    }
}
