<?php

namespace SteveMoretz\LaravelOpcacheClear;

use Crypt;
use Illuminate\Console\Command;

class OpcacheClearCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "opcache:clear";

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
        $originalToken = config("app.key");
        $encryptedToken = Crypt::encrypt($originalToken);

        $response = \Http::get(
            config("opcache.base_url", "http://localhost") . "/opcache-clear",
            [
                "token" => $encryptedToken,
            ]
        )->json();

        if ($response["result"]) {
            $this->line("Cache was successfully cleared!");

            return Command::SUCCESS;
        }else{
            if ($response["reason"]) {
                $this->error($response["reason"]);
            } else {
                $this->error("Unexpected error!");
            }
        }

        return Command::INVALID;
    }
}
