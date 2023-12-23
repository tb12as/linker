<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function user_setting()
    {
        $user = request()->user();
        if ($user) {
            return $this->hasOne(UserSetting::class)->where('user_id', $user->id);
        }

        return $this->hasOne(UserSetting::class)->whereRaw('1=0');
    }
}
