<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('users');
        $table->truncate();

        $user = new User();
        $user->firstName = 'ادمین';
        $user->lastName = 'سایت';
        $user->nationalityCode = '0651234567';
        $user->password = bcrypt('0651234567');
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->firstName = 'دانیال';
        $user->lastName = 'صدیق پور';
        $user->nationalityCode = '0640602959';
        $user->password = bcrypt('0640602959');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->firstName = 'رضا';
        $user->lastName = 'رضایی';
        $user->nationalityCode = '0640501000';
        $user->password = bcrypt('0640501000');
        $user->role_id = 4;
        $user->save();
    }
}
