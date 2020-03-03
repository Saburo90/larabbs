<?php

namespace App\Http\Middleware;

use Closure;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 用户已经登录
        // 用户未邮箱认证
        // 非邮箱认证和登录相关路由
        if ($request->user() && ! $request->user()->hasVerifiedEmail() && ! $request->is('email/*', 'logout')) {
            // 根据客户端返回内容
            return $request->expectsJson() ? abort(403, '您的邮箱尚未激活！') : redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
