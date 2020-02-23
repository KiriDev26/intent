<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';

    protected $fillable = ['from_id', 'to_id', 'is_approve'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function from()
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function to()
    {
        return $this->hasOne(User::class, 'id', 'to_id');
    }
}
