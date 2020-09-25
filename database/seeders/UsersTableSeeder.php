<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //一括消去
        User::truncate();

        User::create([
            'employee_no' => '5060',
            'name' => 'SaraNakamoto',
            'email' => 'nakamoto.sara@kobayashi.bz',
            'password' => Hash::make('koba0001'),
            'fullname' => '中本沙良',
            'phone' => '1111111111',
            'privilege' => '1'
        ]);

        User::create([
            'employee_no' => '6205',
            'name' => 'SatoshiShimizu',
            'email' => 'shimizu.satoshi@kobayashi.bz',
            'password' => Hash::make('koba0001'),
            'fullname' => '清水智',
            'phone' => '0000000000',
            'privilege' => '5'
        ]);

        User::create([
            'employee_no' => '5058',
            'name' => 'RinaMatsumoto',
            'email' => 'matsumoto.rina@kobayashi.bz',
            'password' => Hash::make('koba0001'),
            'fullname' => '松本梨那',
            'phone' => '0000000000',
            'privilege' => '10'
        ]);

    }
}
