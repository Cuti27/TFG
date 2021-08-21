<?php

namespace App\Console\Commands;

use App\Models\waittingId;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckWaittingId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:waittingId';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando comprobará si algún waittingId lleva sin ser asignado más de un día';

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
     * @return int
     */
    public function handle()
    {
        waittingId::where('created_at', '<', Carbon::parse('-24 hours'))->delete();
    }
}
