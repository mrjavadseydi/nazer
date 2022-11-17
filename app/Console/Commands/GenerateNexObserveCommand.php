<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateNexObserveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'next:observe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->output->progressStart(\App\Models\Plan::count());
        foreach (\App\Models\Plan::all() as $plan){
            $plan->next_observe = $plan->miladiNextObserve();
            $plan->save();
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        return 0;
    }
}
