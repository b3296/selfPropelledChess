<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-20
 * Time: 08:56
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    protected $guarded = [];
    public function getOccupationAttribute() {
        return Occupation::select('occupation.id','name')
            ->leftJoin('occupation_pieces','occupation_pieces.occupation_id','=','occupation.id')
            ->where('occupation_pieces.piece_id',$this->id)
            ->where('occupation.type',1)
            ->get();

    }
    public function getRaceAttribute() {
        return Occupation::select('occupation.id','name')
            ->leftJoin('occupation_pieces','occupation_pieces.occupation_id','=','occupation.id')
            ->where('occupation_pieces.piece_id',$this->id)
            ->where('occupation.type',2)
            ->get();
    }

}