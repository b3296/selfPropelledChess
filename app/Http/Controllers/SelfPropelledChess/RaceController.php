<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-19
 * Time: 13:42
 */

namespace App\Http\Controllers\SelfPropelledChess;


use App\Http\Controllers\Controller;
use App\Models\Fetters;
use App\Models\Occupation;
use App\Models\Pieces;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index()
    {
        $occupation = Occupation::where('type',2)->get();// 获取所有角色

        return view('chess.race.index')->with('occupation', $occupation);
    }

    public function create()
    {
        return view('chess.race.create');
    }
    public function store(Request $request)
    {
        //验证 name
        $this->validate($request, [
                'name'=>'required|unique:occupation|max:10',
                'fetters_description'=>'required|string',
                'fetters'=>'required'
            ]
        );
        $name = $request['name'];
        $description = $request['fetters_description'];
        $occupation = new Occupation();
        $occupation->name = $name;
        $occupation->fetters_description = $description;
        $occupation->type = 2;
        $occupation->save();
        $fetters = $request['fetters'];
        (new Fetters)->addAll($occupation->id,$fetters);
        return redirect()->route('race.index')
            ->with('flash_message',
                'Occupation'. $occupation->name.' added!');
    }
    public function show($id)
    {
        $occupation = Occupation::findOrFail($id);
        $fetters = Fetters::where('occupation_id',$id)->get();
        $pieces = Pieces::select('pieces.*')
            ->leftJoin('occupation_pieces','occupation_pieces.piece_id','=','pieces.id')
            ->where('occupation_pieces.occupation_id',$id)
            ->get();
        return view('chess.race.show',compact('occupation','fetters','pieces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occupation = Occupation::findOrFail($id);
        $fetters = Fetters::where('occupation_id',$id)->get();

        return view('chess.race.edit', compact('occupation', 'fetters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $occupation = Occupation::findOrFail($id); // 通过给定id获取角色
        // 验证 name 和 permission 字段
        $this->validate($request, [
            'name'=>'required|max:10|unique:occupation,name,'.$id,
            'fetters_description'=>'required|max:10|unique:occupation,name,'.$id,
            'fetters' =>'required',
        ]);
        $fetters=$request->input('fetters');
        $input = $request->except(['fetters']);
        $occupation->fill($input)->save();

        Fetters::where('occupation_id',$occupation->id)->delete();
        (new Fetters)->addAll($occupation->id,$fetters);
        return redirect()->route('race.index')
            ->with('flash_message',
                'Occupation'. $occupation->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $occupation = Occupation::findOrFail($id);
        $occupation->delete();
        Fetters::where('occupation_id',$id)->delete();

        return redirect()->route('race.index')
            ->with('flash_message',
                'Role deleted!');
    }
}