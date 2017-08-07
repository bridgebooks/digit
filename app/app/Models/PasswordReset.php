<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $fillable = [];

    public function make(String $email)
    {
    	// current time
    	$current = new Carbon();
    	// add expiration time
    	$current->addMinutes(config('auth.reset_token_ttl'));

    	$tokenString = $email .".". $current->toDateTimeString();
    	$resetToken = Crypt::encryptString($tokenString);

    	$this->email = $email;
    	$this->token = $resetToken;
    	$this->used = false;

    	if($this->save()) return $resetToken;

    	return false;
    }

    public function verifyTokenRetrieveUserIdentifier(String $token)
    {
        // Get reset record
        $model = $this->where('token', $token)->where('used', false)->first();

        if(!$model) return false;

        $decryptedTokenString = Crypt::decryptString($model->token);
        $tokenComponents = explode(".", $decryptedTokenString);

        $email = $tokenComponents[0];
        $timestamp = new Carbon($model->created_at);

        $now = new Carbon();
        $resetTTL = config('auth.reset_token_ttl');

        if ($timestamp->diffInMinutes($now, false) <= $resetTTL) {
            $model->used = true;
            $model->save();

            return $model->email;
        } else {
            return false;
        }
    }
}
