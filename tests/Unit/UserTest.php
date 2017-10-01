<?php 

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase 
{
    use RefreshDatabase;

    /** @test */
    function it_records_transaction_when_user_balance_updated()
    {
        $user = factory('App\User')->create();

        $user->updateBalance(33.00);

        $this->assertDatabaseHas('user_transaction', [
            'user_id' => $user->id,
            'amount' => 33.00,
        ]);

        // $userTransaction = UserTransaction::first();

        // $this->assertEquals($userTransaction->id, $thread->id);
    }
}