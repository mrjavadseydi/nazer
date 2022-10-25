<?php

namespace App\Console\Commands;

use App\Models\Plan;
use Illuminate\Console\Command;

class UpldateLocationType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update location type';

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

        Plan::where('address','like',"%روستا%")->update(['location_type'=>'روستایی']);
        Plan::where('address','not like',"%روستا%")->update(['location_type'=>'شهری']);
        return 0;
    }
}
