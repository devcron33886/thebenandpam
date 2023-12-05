<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Guest extends Model
{
    use HasFactory, Notifiable,SoftDeletes;

    public function routeNotificationForAfricasTalking($notification)
    {
        return $this->phone_number;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->generateUniqueInvitationCode();
        });
    }

    protected function generateUniqueInvitationCode()
    {
        $codeLength = 6;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $invitationCode = '';

        // Generate a unique code
        do {
            $invitationCode = substr(str_shuffle($characters), 0, $codeLength);
        } while ($this->codeExists($invitationCode));

        $this->attributes['invitation_code'] = $invitationCode;
    }

    protected function codeExists($code)
    {
        return static::where('invitation_code', $code)->exists();
    }
}
