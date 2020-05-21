<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// 引入 laravel-permission 模型
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 获取所有角色并将其传递到视图
        $roles = Role::get();
        return view('admin.user.create', ['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 验证 name、email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:120',
            'phone'=>'required|unique:users',
            'email'=>'required|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = User::create($request->only('phone','email', 'name', 'password')); //只获取 phone,email、name、password 字段

        $roles = $request['roles']; // 获取输入的角色字段
        // 检查是否某个角色被选中
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }
        // 重定向到 users.index 视图并显示消息
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $permissions = $user->permissions;
        var_dump($permissions);
        // 获取用户通过角色继承的所有权限
        $permissions = $user->getAllPermissions()->pluck('name');

        dump($permissions);
        // 获取所有已定义角色的集合
        $roles = $user->getRoleNames();
        dd($roles);
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // 通过给定id获取用户
        $roles = Role::get(); // 获取所有角色

        return view('admin.user.edit', compact('user', 'roles')); // 将用户和角色数据传递到视图
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
        $user = User::findOrFail($id); // 通过id获取给定角色

        // 验证 name, email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:120',
            'phone'=>'required|unique:users,email,'.$id,
            'email'=>'required|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password','phone']); // 获取 name, email 和 password 字段
        $roles = $request['roles']; // 获取所有角色
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  // 如果有角色选中与用户关联则更新用户角色
        } else {
            $user->roles()->detach(); // 如果没有选择任何与用户关联的角色则将之前关联角色解除
        }
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 通过给定id获取并删除用户
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully deleted.');
    }
}
