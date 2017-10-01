<?php

use App\UserTransaction;
use Illuminate\Database\Seeder;

class UserTransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\UserTransaction::class, 50, 4)->create();
    }
}
