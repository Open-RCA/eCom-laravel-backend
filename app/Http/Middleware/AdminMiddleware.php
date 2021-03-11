<?php
    namespace App\Http\Middleware;
    use Closure;
    use JWTAuth;
    use Exception;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
    class AdminMiddleware extends BaseMiddleware
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
            $roles = auth()->user()->roles;
            foreach ($roles as $role) {
                if($role["type"] == "Admin"){
                    return $next($request);
                }
            }

            return response()->json(["message"=> "This route is for Authorized users only ... "], 400);
        }

    }