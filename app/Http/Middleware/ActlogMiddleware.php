<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Route;

class ActlogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $status = $response->status();
        $this->actlog($request, $status);
        return $response;
    }

    public function actlog($request, $status){
        $user = $request -> user();
        $data = $this->setData($user, $request, $status);

        // Actlog::create($data);
        \Log::channel('actLog')->debug($data);
    }

    private function setData($user, $request, $status){
        $request_arr = $request->toArray();

        //パスワードなどはlogに残さない。
        unset($request_arr['password']);
        unset($request_arr['password_confirmination']);
        unset($request_arr['old_password']);

        $data = [
            'user_id' => $user ? $user->id : 'guest',
            'route' => Route::currentRouteName(),
            'url' => $request -> path(),
            'method' => $request -> method(),
            'status' => $status,
            'message' => count($request_arr) != 0 ? json_encode($request_arr) : null,
            'remote_addr' => $request -> ip(),
            'user_agent' => $request -> userAgent(),
        ];

        $stmt = $data['method'].'('.$data['status'].') '.$data['url'].'('.$data['route'].')'.' user:'.$data['user_id'].' '.$data['message'].'   from '.$data['remote_addr'].' '.$data['user_agent'];

        // $stmt = 'hello';
        return $stmt;
    }
}
