<?php

namespace Thepsion5\Menuizer\Support\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor() { return 'menuizer'; }
}
