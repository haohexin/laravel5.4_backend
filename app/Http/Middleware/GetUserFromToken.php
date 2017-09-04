<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

/**
 * 根据原middleware \Tymon\JWTAuth\Middleware\GetUserFromToken::class 修改.
 * Class GetUserFromToken
 *
 * @package App\Http\Middleware
 */
class GetUserFromToken extends BaseMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ( !$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', ['message' => '未登录，请登录后操作！', 'status_code' => 401], 401);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', ['message' => '登录已经过期，重新登录！', 'status_code' => 401], 401);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', ['message' => '登录已经失效！', 'status_code' => 401], 401);
        }

        if ( !$user) {
            return $this->respond('tymon.jwt.user_not_found', ['message' => '未找到用户！', 'status_code' => 404], 404);
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }

    /**
     * Fire event and return the response.
     *
     * @param  string $event
     * @param  array $error
     * @param  int $status
     * @param  array $payload
     * @return mixed
     */
    protected function respond($event, $error, $status, $payload = [])
    {
        $response = $this->events->fire($event, $payload, true);

        return $response ?: $this->response->json($error, $status);
    }
}
