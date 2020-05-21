<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-19
 * Time: 14:09
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fetters extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'occupation_id','num','description'
    ];
    protected $guarded = [];
    public function addAll($occupation_id,Array $data)
    {
        foreach ($data as $key=>&$val){
            if(empty($val['num']) || empty($val['description'])){
                unset($data[$key]);
                continue;
            }
            $val['occupation_id'] = $occupation_id;
        }
        $rs = DB::table($this->getTable())->insert($data);
        return $rs;
    }
}