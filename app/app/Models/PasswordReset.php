<?php

namespace App\Models;

use App\Exceptions\ResetTokenExpiredException;
use App\Exceptions\ResetTokenNotFoundException;
use Exception;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $fillable = [];

    public function make(String $email)
    {
    	// current time
    	$current = new Carbon();
    	$ttl = config('auth.reset_token_ttl');
    	$current = $current->addMinutes($ttl);

    	$tokenString = sprintf("%s.%s", $email, $current->toDateTimeString());
    	$resetToken = encrypt($tokenString);

    	$this->email = $email;
    	$this->token = $resetToken;
    	$this->used = false;

    	if($this->save()) return $resetToken;

    	return false;
    }

    /**
     * @param String $token
     * @throws ResetTokenNotFoundException
     * @throws ResetTokenExpiredException
     * @throws Exception
     */
    public function verifyTokenRetrieveUserIdentifier(String $token)
    {
        // Get reset record
        $model = $this->where('token', $token)
            ->where('used', 0)
            ->first();

        if(!$model) throw new ResetTokenNotFoundException("No password reset found for this account");

        try {
            $ttl = config('auth.reset_token_ttl');

            $now = new Carbon();
            $expiry = new Carbon($model->created_at);
            $expiry = $expiry->addMinutes($ttl);

            if ($now->diffInMinutes($expiry, true) <= $ttl) {
                $model->used = true;
                $model->save();

                return $model->email;
            }

            throw new ResetTokenExpiredException("Your password reset link has expired. Please request for another password reset");
        } catch (DecryptException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
