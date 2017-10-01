<?php

namespace App;

use App\UserTransaction;
use App\Exceptions\UserBalanceUpdateException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Table accociated with the model 
     * 
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * [getAmountAttribute description]
     * @return [type] [description]
     */
    public function getAmountAttribute()
    {
        return number_format($this->attributes['amount'], 2, ',', ' ');
    }

    /**
     * User transactions
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(UserTransaction::class);
    }

    /**
     * Update balance of a user
     * 
     * @param  decimal
     */
    public function updateBalance($amount)
    {
        \DB::beginTransaction();

        try {
            $this->balance += $amount;
            $this->updated_at = \Carbon\Carbon::now();

            $this->transactions()->create([
                'amount' => $amount,
                'created_at' => \Carbon\Carbon::now()
            ]);

            $this->save();

            \DB::commit();
            
        } catch (\Exception $e) {
            \DB::rollback();
            throw new UserBalanceUpdateException("Ошибка при попытке пополнить баланс пользователя с id={$this->id}");
        }
    }
}
