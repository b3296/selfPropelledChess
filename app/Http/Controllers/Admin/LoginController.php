<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AccountNotExists;
use App\Http\Controllers\Controller;
use App\Models\ThirdLoginBind;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $_user_name = 'phone';
    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//	public function __construct() {
////        $this->middleware('guest')->except('logout');
//	}

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login( Request $request ) {
        $login_name = $request->input( 'login_name' );
        if ( str_contains( $login_name, '@' ) ) {
            $this->_user_name = 'email';
            $request['email'] = $login_name;
            $validator        = Validator::make( $request->all(), [
                'email' => [
                    'required',
                    'email'
                ],
            ] );
        } else {
            $request['phone'] = $login_name;
            $validator        = Validator::make( $request->all(), [
                'phone' => [
                    'required',
                ],
            ] );
        }

        if ( $validator->fails() ) {
            return $this->err( 'account_not_exists' );
        }

        if ( $this->hasTooManyLoginAttempts( $request ) ) {
            $this->fireLockoutEvent( $request );

            return $this->err( 'login_pwd_fail_many_times' );
        }

        if ($request->has('login_type')) {
            $re = $this->bindThirdUid($request);
            if ($re instanceof Response) {
                return $re;
            }
        }
        try {
            if ($this->attemptLogin( $request ) ) {
                return $this->sendLoginResponse( $request );
            }
        } catch ( Exceptions $exception ) {
            $this->incrementLoginAttempts( $request );
            return $this->err( 'account_not_exists' );
        }
        $this->incrementLoginAttempts( $request );

        return $this->err( 'password_error',400 );
    }

    public function username() {
        return $this->_user_name;
    }

    protected function attemptLogin( Request $request ) {

        $this->validateLoginBefore( $request );
        return $this->guard()->attempt(
            $this->credentials( $request ), $request->input( 'remember' )
        );
    }

    protected function validateLoginBefore( Request $request ) {
        $login_name = $request->input( 'login_name' );
        if ( $this->_user_name == 'email' ) {
            $email = $login_name;
            $user  = User::factoryEmail( compact( 'email' ), false );
        } else {
            $phone = $login_name;
            $user  = User::factory( compact( 'phone' ), false );
        }

        if ( ! $user->exists ) {
            throw new \Exception('account no exists');
        }
    }

    protected function authenticated( Request $request, $user ) {

        return redirect('admin/users');
    }

    public function user( Request $request ) {
        return $this->authenticated( $request, Auth::user() );
    }

    public function logout( Request $request ) {
        $this->guard()->logout();

        $request->session()->invalidate();

        return [ 'errorcode' => 0 ];
    }

    protected function bindThirdUid( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'login_type'   => ['required', 'string', 'in:weixin'],
            'access_token' => ['required', 'string'],
            'third_uid'    => ['required', 'string']
        ] );
        if ( $validator->fails() ) {
            return $this->err(41000);
        }

        //判断账号密码是否正确
        if ( $this->_user_name == 'email' ) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone', $request->phone)->first();
        }
        if (!$user) {
            return $this->err( 'account_not_exists' );
        }
        //验证密码
        if (!\Hash::check($request->password, $user->password)) {
            return $this->err( 'password_error' );
        }

        //判断传入third_uid与服务器保存的session信息（通过code生成third_uid，存入session）是否相同，若不相同，返回微信授权已失效40022
        $wechatUser = Session('wechat.oauth_user');
        if ($wechatUser['token']['unionid'] !== $request->third_uid) {
            return $this->err(40022);
        }

        //根据用户id，login_type查询第三方快捷登录绑定记录表（third_login_binds表）user_id是否存在，若已存在，返回用户已绑定其他微信账号40023
        $userBindInfo = ThirdLoginBind::where('user_id', $user->id)
            ->where('login_type', $request->login_type)
            ->first();
        if ($userBindInfo) {
            return $this->err(40023);
        }

        //根据login_type，third_uid查询第三方快捷登录绑定记录表（third_login_binds表）若存在绑定记录，返回微信授权登录用户已经绑定智序商城后台用户40020
        $bindInfo = ThirdLoginBind::where('login_type', $request->login_type)
            ->where('third_uid', $request->third_uid)
            ->first();
        if ($bindInfo) {
            return $this->err(40020);
        }

        //若不存在绑定记录，插入第三方快捷登录绑定表（third_login_binds表）记录
        ThirdLoginBind::create([
            'user_id' => $user->id,
            'login_type' => $request->login_type,
            'access_token' => $request->access_token,
            'third_uid' => $request->third_uid,
        ]);
    }
}
