<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)
            ->create()
            ->each(function ($u) {
                $transactionCount = rand(4, 10);
                $u->transactions()->saveMany(factory(App\UserTransaction::class, $transactionCount)->make());
            });;
    }
}
