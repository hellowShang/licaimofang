<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class showtime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show now time';

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
     * @return mixed
     */
    public function handle()
    {
        //
        echo date("Y-m-d H:i:s")."\n";
    }
}
