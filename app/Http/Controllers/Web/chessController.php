<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-25
 * Time: 10:13
 */

namespace App\Http\Controllers\Web;


use App\Heplers\StrategyHelper;
use App\Http\Controllers\Controller;
use App\Models\Fetters;
use App\Models\Occupation;
use App\Models\OccupationPieces;
use App\Models\Pieces;
use App\Models\Praise;
use App\Models\Strategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class chessController extends Controller
{
    public function PieceIndex()
    {
        $pieces = Pieces::orderBy('expend')->get();

        return view('web.chess.piece_index')->with('pieces', $pieces);
    }

    public function PieceShow($id)
    {
        $piece = Pieces::find($id);
        return view('web.chess.piece_show')->with('piece', $piece);
    }

    public function OccupationIndex()
    {
        $occupation = Occupation::where('type', 1)->get();

        return view('web.chess.occupation_index')->with('occupation', $occupation);
    }

    public function OccupationShow($id)
    {
        $occupation = Occupation::findOrFail($id);
        $fetters = Fetters::where('occupation_id', $id)->get();
        $pieces = Pieces::select('pieces.*')
            ->leftJoin('occupation_pieces', 'occupation_pieces.piece_id', '=', 'pieces.id')
            ->where('occupation_pieces.occupation_id', $id)
            ->orderBy('pieces.expend')
            ->get();
        return view('web.chess.occupation_show', compact('occupation', 'fetters', 'pieces'));
    }

    public function RaceIndex()
    {
        $occupation = Occupation::where('type', 2)->get();

        return view('web.chess.race_index')->with('occupation', $occupation);
    }

    public function RaceShow($id)
    {
        $occupation = Occupation::findOrFail($id);
        $fetters = Fetters::where('occupation_id', $id)->get();
        $pieces = Pieces::select('pieces.*')
            ->leftJoin('occupation_pieces', 'occupation_pieces.piece_id', '=', 'pieces.id')
            ->where('occupation_pieces.occupation_id', $id)
            ->orderBy('pieces.expend')
            ->get();
        return view('web.chess.race_show', compact('occupation', 'fetters', 'pieces'));
    }

    public function strategy(Request $request)
    {
        $piece_ids = $request->input('pieces');
        $pieces = Pieces::orderBy('expend')->get();
        if (empty($piece_ids)) {
            return view('web.chess.piece_index', ['errors' => '请选择棋子', 'pieces' => $pieces]);
        } elseif (count($piece_ids) > 10) {
            return view('web.chess.piece_index', ['errors' => '最多选择10个棋子', 'pieces' => $pieces]);
        }

        list($pieces,$fetters) = StrategyHelper::show($piece_ids);
        return view('web.chess.strategy', compact('pieces', 'fetters'));

    }

    public function strategySave(Request $request)
    {
        $this->validate($request, [
            'pieces' => 'required|array|max:10',
            'name' => 'required|string|max:150'
        ]);
        $userInfo = session()->get('userInfo');
        $user_id = $userInfo['id'];
        $count = Strategy::where('user_id', $user_id)->where('created_at', '>=', date('Y-m-d'))->count();
        if ($count >= $userInfo['strategy_num']) {
            return view('web.chess.strategy', compact('pieces', 'fetters', 'errors'));
        }
        $piece_ids = implode(',', $request->input('pieces'));
        $name = $request->input('name') . '(' . $userInfo['name'] . ')';
        $description = $request->input('description');
        Strategy::create(compact('user_id', 'piece_ids', 'name','description'));
        return redirect()->route('web.chess.strategy.list')->with('flash_message',
            'Strategy successfully added.');
    }

    public function strategyList()
    {
        $strategys = Strategy::orderBy('praise_num','desc')->orderBy('created_at','desc')->paginate(10);
        return view('web.chess.strategy_list',compact('strategys'));
    }

    public function strategyShow($id)
    {
        $strategy = Strategy::findOrFail($id);
        $piece_ids = explode(',',$strategy->piece_ids);
        list($pieces,$fetters) = StrategyHelper::show($piece_ids);
        $is_praise = 0;
        if(session()->exists('userInfo')){
            $user_id = session()->get('userInfo')['id'];
            $praise = Praise::where('user_id',$user_id)->where('work_id',$id)->where('type',1)->first();
            if($praise){
                $is_praise = 1;
            }
        }
        $strategy->is_praise = $is_praise;
        return view('web.chess.strategy_show', compact('strategy','pieces', 'fetters'));
    }
}