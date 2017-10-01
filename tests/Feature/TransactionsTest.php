<?php 

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionsTest extends TestCase 
{
    use RefreshDatabase;

    /** @test */
    function it_shows_user_info()
    {
        $user = factory('App\User')->create();

        $this->get("/transactions?name={$user->name}")
            ->assertSee("Пользователь {$user->name} не проводил каких либо операций");
    }

    /** @test */
    function it_shows_info_message_if_user_does_not_exist()
    {
        $username = "NoName";

        $this->get("/transactions?name={$username}")
            ->assertSee("Пользователя с таким именем не существует");
    }

    /** @test */
    function it_shows_transaction_history_for_user()
    {
        $user = factory('App\User')->create();
        $transaction = factory('App\UserTransaction')->create(['user_id' => $user->id]);

        $this->get("/transactions?name={$user->name}")
            ->assertSee("{$transaction->created_at}")
            ->assertSee("{$transaction->amount}");
    }
}