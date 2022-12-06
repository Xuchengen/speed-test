<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        return response(app()->getLocale() . '中华人民共和国')->header('X-LiteSpeed-Vary', 'cookie=lang');
    }

}
