<?php namespace EmberGrep\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'stripe_id', 'trial_ends_at',
        'created_at', 'updated_at',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
