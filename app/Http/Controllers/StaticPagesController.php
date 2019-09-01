<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    /**
     * 主页显示
     */
    public function home()
    {
        return view('static_pages.home');
    }

    /**
     * 显示帮助页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function help()
    {
        return view('static_pages.help');
    }

    /**
     * 显示关于页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('static_pages.about');
    }
}
