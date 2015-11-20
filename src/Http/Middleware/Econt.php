<?php
namespace Rolice\Econt\Http\Middleware;

use App;
use Input;
use Config;
use Closure;
use Illuminate\Http\Request;

class Econt
{

    /**
     * Create a new middleware instance.
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = Input::get('lang') ?: Config::get('app.locale');

        if (!preg_match('#[a-z]{2}#', $lang)) {
            $lang = Config::get('app.locale');
        }

        App::setLocale($lang);

        return $next($request);
    }
}