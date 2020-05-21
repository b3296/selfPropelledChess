<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-28
 * Time: 14:12
 */

namespace App\Heplers;


use App\Models\Fetters;
use App\Models\OccupationPieces;
use App\Models\Pieces;

class StrategyHelper
{
    static public function show($piece_ids)
    {
        $occupation_ids = OccupationPieces::select('occupation_id')
            ->selectRaw('count(occupation_id) as occupation_count')
            ->whereIn('piece_id', $piece_ids)
            ->groupBy('occupation_id')
            ->get();
        $fetters = [];
        $pieces = Pieces::whereIn('id', $piece_ids)->orderBy('expend')->get();
        $occupation_ids->map(function ($item) use (&$fetters, $pieces) {
            $fet_res_all = Fetters::select('num', 'description', 'name as occupation_name', 'occupation_id')
                ->leftJoin('occupation', 'occupation.id', '=', 'fetters.occupation_id')
                ->where('occupation_id', $item->occupation_id)
                ->where('num', '<=', $item->occupation_count)
                ->orderBy('num', 'desc')
                ->get();

            if ($fet_res_all->isNotEmpty()) {
                $fet_res = $fet_res_all->first();
                $fet_res->description = implode('&&',$fet_res_all->pluck('description')->all());
                $piece_arr = [];
                foreach ($pieces as $piece) {
                    if (in_array($fet_res['occupation_id'], $piece->occupation->pluck('id')->all())) {
                        $piece_arr[] = $piece->nick_name;
                    }
                    if (in_array($fet_res['occupation_id'], $piece->race->pluck('id')->all())) {
                        $piece_arr[] = $piece->nick_name;
                    }
                }
                $fet_arr = $fet_res->toArray();
                $fet_arr['pieces'] = $piece_arr;
                $fetters[] = $fet_arr;
            }
        });
        return [$pieces,$fetters];
    }
}