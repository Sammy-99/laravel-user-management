<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-cmd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command just for testing';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "I am createing new command";
    }
}
