<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-28
 * Time: 08:55
 */

namespace App\Http\Middleware;

use Closure;

class CheckWebLogin
{
    public function handle($request,Closure $next)
    {
        if(session()->exists('userInfo')){
            return $next($request);
        }
        if($request->ajax()){
            return  response(['code'=>202,'msg'=>'请先登录']);
        }
        return redirect()->route('web.login');
    }
}