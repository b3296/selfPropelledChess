<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-26
 * Time: 10:24
 */

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Models\WebUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class WebUserController extends Controller
{
    public function register()
    {
        return view('web.user.register');
    }

    public function registerDoit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:30','unique:web_users'],
            'phone' => ['required','string','regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/','unique:web_users'],
            'password' => ['required','string','min:6','confirmed'],
        ]);
        if ($validator->fails()) {
            return view('web.user.register',['errors'=>$validator->errors()]);
        }
        $name = $request->input('name');
        $phone = $request->input('phone');
        $password = $request->input('password');
        $pwd_rand = mt_rand(1000,9999);
        $password = md5($password.$pwd_rand.'web_user');
        WebUser::create(compact('name','phone','password','pwd_rand'));
        return redirect()->route('web.login');
    }

    public function login()
    {
        return view('web.user.login');
    }
    public function loginDoit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required','string','regex:/^13\d{9}$|^14\d{9}$|^15\d{9}$|^17\d{9}$|^18\d{9}$/','exists:web_users'],
            'password' => ['required','string','min:6'],
        ]);
        if ($validator->fails()) {
            return view('web.user.login',['errors'=>$validator->errors()]);
        }
        $user = WebUser::where('phone',$request->input('phone'))->first();
        if($user->password != md5($request->input('password').$user->pwd_rand.'web_user')){
            return view('web.user.login',['pwd_error'=>'the password is error']);
        }elseif ($user->is_pass==0){
            return view('web.user.login',['pwd_error'=>'账号暂不能登录，具体请联系博主']);
        }
        $client_ip=$request->getClientIp();
        $user->last_login_ip = $client_ip;
        $user->save();
        session(['userInfo'=>array_only($user->toArray(),['id','name','strategy_num'])]);
        $url = $request->session()->get('redirect_url');
        if($url && strpos($url,'list')!==false){
            return redirect($url);
        }
        return redirect()->route('web.chess.piece.index');
    }

    public function logout()
    {
        session()->forget('userInfo');
        return view('welcome');
    }
}