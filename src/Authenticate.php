<?php
//
//namespace Stechstudio\LaravelSocialiteAuth;
//
//use Illuminate\Auth\AuthenticationException;
//use Illuminate\Auth\Middleware\Authenticate as Middleware;
//use Closure;
//use Illuminate\Contracts\Auth\Factory as Auth;
//
//class Authenticate extends Middleware
//{
//    /**
//     * Get the path the user should be redirected to when they are not authenticated.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return string
//     */
//    protected function redirectTo($request)
//    {
//        if (! $request->expectsJson()) {
//            return route('oauth.login');
//        }
//    }
//
//    /**
//     * Determine if the user is logged in to any of the given guards.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  array  $guards
//     * @return void
//     *
//     * @throws \Illuminate\Auth\AuthenticationException
//     */
//    protected function authenticate($request, array $guards)
//    {
//        dd($request, $guards);
//        if (empty($guards)) {
//            $guards = [null];
//        }
//
//        foreach ($guards as $guard) {
//            if ($this->auth->guard($guard)->check()) {
//                return $this->auth->shouldUse($guard);
//            }
//        }
//
//        throw new AuthenticationException(
//            'Unauthenticated.', $guards, $this->redirectTo($request)
//        );
//    }
//}
