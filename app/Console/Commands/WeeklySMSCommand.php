<?php

namespace App\Console\Commands;

use App\Models\Observe;
use App\Models\Supervisor;
use Illuminate\Console\Command;

class WeeklySMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly Sms';

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
        $todayObserves = Observe::where('created_at','>',now()->subDays(7)->startOfDay())->groupBy('supervisor_id')->get('supervisor_id')->toArray();
        //make sure there is no duplicate supervisor
//        $todayObserves = array_unique($todayObserves);


        foreach ($todayObserves as $supervisor){
            ///get count of supervisor observe in this day
            $count = Observe::where('created_at','>',now()->startOfDay())->where('supervisor_id',$supervisor)->count();
            //get supervisor name and phone
            $supervisor = Supervisor::where('id',$supervisor)->first();
            $name = $supervisor->fullName;
            $phone  = fa2en($supervisor->phone);

            ///send report to supervisor
            print_r(sendSms('m533x72h476aql1',$phone,['name'=>$name,'count'=>$count]));
        }
        sendSms('qs1n8hh4o6bqew5','09151641217',['name'=>'مهندس پاسبان','count'=>count($todayObserves)]);
        sendSms('qs1n8hh4o6bqew5','09397688174',['name'=>'مهندس صیدی','count'=>count($todayObserves)]);
        return 0;
    }
}
