<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $fillable = ['user_id', 'text'];

	/**
     * Disable updated_at.
     *
     * @var const
     */
	const UPDATED_AT = null;
	
    /**
     * Get the user that owns the message.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
