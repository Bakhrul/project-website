<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class m_user extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Notifiable,
        Authenticatable,
        CanResetPassword;

    protected $table = 'm_user';
    protected $primaryKey = 'u_id';

    // public $remember_token = false;

    public function getAuthPassword() {
        return $this->u_password;
     }


}
