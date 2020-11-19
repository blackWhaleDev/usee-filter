<?php

namespace youness_usee\filter\app;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next)
    {

        if ($this->applyType() === 'between'){
            if (!request()->has($this->applyFirst()) && !request()->has($this->applySecond())) {
                return $next($request);
            }elseif (request($this->applyFirst()) === null  || request($this->applySecond()) === null ){
                return $next($request);
            }
        }else{
            if (!request()->has($this->applyFirst()) || request($this->applyFirst()) === null) {
                return $next($request);
            }
        }

        $builder = $next($request);

        return $this->applyFilter($builder);
    }

    protected abstract function applyType();

    protected abstract function applyFilter($builder);

    protected abstract function applyFirst();

    protected abstract function applySecond();

}