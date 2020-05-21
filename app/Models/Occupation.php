<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-19
 * Time: 14:09
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','fetters_description'
    ];
    protected $guarded = [];
    protected $table='occupation';

}