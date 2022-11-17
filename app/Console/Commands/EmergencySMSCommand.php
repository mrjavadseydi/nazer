<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\Supervisor;
use Illuminate\Console\Command;

class EmergencySMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:emergency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send Emergency observe sms';

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
        $supervisors = Supervisor::all();
        foreach ($supervisors as $supervisor){
            $needObserve = Plan::where('supervisor_id',$supervisor->id)->where('next_observe','<',now())->count();
            if ($needObserve>0){
               sendSms('278fg3uwdks8809',fa2en($supervisor->phone),['name'=>$supervisor->fullName,'count'=>$needObserve]);
            }
        }
        return 0;
    }
}
