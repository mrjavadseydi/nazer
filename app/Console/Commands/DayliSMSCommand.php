<?php

namespace App\Console\Commands;

use App\Models\Observe;
use App\Models\Supervisor;
use Illuminate\Console\Command;

class DayliSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Sms';

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
        $todayObserves = Observe::where('created_at','>',now()->startOfDay())->groupBy('supervisor_id')->get('supervisor_id')->toArray();
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
            print_r(sendSms('22zq12oe8m7fwpx',$phone,['name'=>$name,'count'=>$count]));
        }
        $all = Observe::where('created_at','>',now()->startOfDay())->count();
        sendSms('1gjqri39kxvtuyg','09151641217',['name'=>'مهندس پاسبان','count'=>$all]);
        sendSms('1gjqri39kxvtuyg','09397688174',['name'=>'مهندس صیدی','count'=>$all]);
        return 0;
    }
}
