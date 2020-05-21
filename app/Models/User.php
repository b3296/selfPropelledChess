<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    public static function firstDefaultFills(array $fills) {
        $phone = 0;

        $default = compact('phone');

        return array_reduce(array_keys($default), function ($fills, $key) use ($default) {
            return array_add($fills, $key, array_get($fills, $key, $default[$key]));
        }, $fills);
    }

    public static function firstAttributesFills(array $fills) {
        return array_only($fills, [
            'phone',
        ]);
    }

    public static function firstValuesFills(array $fills) {
        return array_only($fills, []);
    }

    public static function factoryEmail(array $fills, $autoSave = true) {
        $fills = static::firstDefaultFillsEmail($fills);

        return tap(
            static::firstOrNew(
                static::firstAttributesFillsEmail($fills),
                static::firstValuesFillsEmail($fills)
            ),
            function (Model $model) use ($autoSave) {
                if ($autoSave && !$model->exists) {
                    $model->save();
                }
            }
        );
    }

    public static function firstDefaultFillsEmail(array $fills) {
        $email = 0;

        $default = compact('email');

        return array_reduce(array_keys($default), function ($fills, $key) use ($default) {
            return array_add($fills, $key, array_get($fills, $key, $default[$key]));
        }, $fills);
    }

    public static function firstAttributesFillsEmail(array $fills) {
        return array_only($fills, ['email']);
    }

    public static function firstValuesFillsEmail(array $fills) {
        return array_only($fills, []);
    }

    protected $guarded = [];
    protected $casts = [
        'id' => 'integer',
        'phone' => 'integer',
        'email' => 'string',
    ];

    public function getMallIdAttribute() {
        return Mall::orderBy('id')->value('id');
    }

    public function getIsMasterAttribute() {
        return $this->type === 1;
    }

    public function getIsSubAttribute() {
        return !$this->getIsMasterAttribute();
    }

    public function ctrlShops() {
        if ($this->getIsMasterAttribute()) {
            return Shop::where('mall_id', $this->getMallIdAttribute())->get();
        } else {
            return Shop::where('user_id', $this->id)->get();
        }
    }
}
