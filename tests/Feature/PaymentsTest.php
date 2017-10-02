<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentsTest extends TestCase 
{
    use RefreshDatabase;

    /** @test */
    function it_recharges_user_balance_when_recieving_proper_get_request_from_provider1()
    {
        $user = factory('App\User')->create();

        $amount = 77.00;

        $hash = md5($user->id . $amount . 'SomeRandomKeyForProvider1');

        $request = $this->get("payments/test1?a=$user->id&b=$amount&md5=$hash");

        $this->get("/transactions?name={$user->name}")
            ->assertSee("{$amount}");

        $this->assertDatabaseHas('user', [
            'id' => $user->id,
            'balance' => $amount
        ]);

        $this->assertDatabaseHas('user_transaction', [
            'user_id' => $user->id,
            'amount' => $amount
        ]);
    }

    /** @test */
    function it_recharges_user_balance_when_recieving_proper_get_request_from_provider2()
    {
        $user = factory('App\User')->create();

        $amount = 88.00;

        $hash = md5($user->id . $amount . 'SomeRandomKeyForProvider2');

        $request = $this->get("payments/asdgOasds?x=$user->id&y=$amount&md5=$hash");

        $this->get("/transactions?name={$user->name}")
            ->assertSee("{$amount}");

        $this->assertDatabaseHas('user', [
            'id' => $user->id,
            'balance' => $amount
        ]);

        $this->assertDatabaseHas('user_transaction', [
            'user_id' => $user->id,
            'amount' => $amount
        ]);
    }

     /** @test */
    function it_doesnt_change_user_balance_when_recieving_wrong_hash_from_provider1()
    {
        $user = factory('App\User')->create();

        $amount = 88.00;

        $request = $this->get("payments/test1?a=$user->id&b=$amount&md5=WrongHash");

        $this->get("/transactions?name={$user->name}")
            ->assertSee("0,00");

        $this->assertDatabaseHas('user', [
            'id' => $user->id,
            'balance' => '0.0'
        ]);
    }

    /** @test */
    function it_doesnt_change_user_balance_when_recieving_wrong_hash_from_provider2()
    {
        $user = factory('App\User')->create();

        $amount = 88.00;

        $request = $this->get("payments/asdgOasds?x=$user->id&y=$amount&md5=WrongHash");

        $this->get("/transactions?name={$user->name}")
            ->assertSee("0,00");

        $this->assertDatabaseHas('user', [
            'id' => $user->id,
            'balance' => '0.0'
        ]);
    }
}