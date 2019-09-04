<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Status;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    /**
     * 主页显示
     */
    public function home()
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(10);
        }

        return view('static_pages/home', compact('feed_items'));
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
