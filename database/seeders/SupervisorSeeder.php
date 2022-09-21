<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('supervisors');
        $table->truncate();

        $fullName = 'ادمین';
        $nationalityCode = '0651234567';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();



        $fullName = 'آقای اربابی';
        $nationalityCode = '0653207522';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();




        $fullName = 'آقای خواجوی';
        $nationalityCode = '0640369456';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();



        $fullName = 'آقای دادی';
        $nationalityCode = '0653162073';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();



        $fullName = 'آقای رضایی';
        $nationalityCode = '5239972648';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();



        $fullName = 'آقای کاووسی';
        $nationalityCode = '0640102026';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();



        $fullName = 'آقای نداف';
        $nationalityCode = '0640392822';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();




        $fullName = 'خانم مهردادیان';
        $nationalityCode = '0653098677';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();



        $fullName = 'خانم هاشمی زاده';
        $nationalityCode = '2991689803';
        $password = bcrypt($nationalityCode);

        $supervisor = new Supervisor();
        $supervisor->fullName = $fullName;
        $supervisor->nationalityCode = $nationalityCode;
        $supervisor->password = $password;
        $supervisor->save();

        $user = new User();
        $user->firstName = $fullName;
        $user->nationalityCode = $nationalityCode;
        $user->password = $password;
        $user->role_id = 4;
        $user->save();
    }
}
