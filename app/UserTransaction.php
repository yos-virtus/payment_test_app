<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
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
    protected $table = 'user_transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at', 'amount'
    ];

    /**
     * Author of transaction
     * 
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [getAmountAttribute description]
     * @return [type] [description]
     */
    public function getAmountAttribute()
    {
        return number_format($this->attributes['amount'], 2, ',', ' ');
    }
}
