<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-01
 * Time: 13:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\WebUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebUserController extends Controller
{
    public function list(Request $request)
    {
        $name = $request->input('name',null);
        $users = WebUser::when(!is_null($name),function($query)use($name){
                return $query->where('name','like','%'.$name.'%');
            })->orderBy('created_at','desc')
            ->paginate(10);
        return view('admin.web_user.list',compact('users'));
    }

    public function edit($id)
    {
        $user = WebUser::findOrFail($id);
        return view('admin.web_user.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'=>['required','integer'],
            'name'=>['required','string'],
            'is_pass'=>['required','integer','in:0,1'],
            'strategy_num'=>['required','integer'],
        ]);
        if($validator->fails()){
            return $this->err(400,$validator->errors());
        }
        $user = WebUser::findOrFail($request->input('id'));
        $user->fill(array_only($request->all(),['name','is_pass','strategy_num']));
        $user->save();
        return view('admin.web_user.edit',compact('user'));
    }

}