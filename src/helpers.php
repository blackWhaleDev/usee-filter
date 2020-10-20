<?php



if (! function_exists('pipe')) {
    function pipe($cause, $classes = [])
    {
        return app(\Illuminate\Pipeline\Pipeline::class)
            ->send($cause)
            ->through($classes)
            ->thenReturn();
    }
}
