<?php
/**
 * 微博控制器
 */
namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        //判断登录后才能操作
        $this->middleware("auth");
    }

    /**
     * 发布微博
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'content' => "required|max:140"
        ]);

        Auth::user()->statuses()->create([
            'content' => $request['content']
        ]);

        session()->flash('success',"发布成功");
        return redirect()->back();
    }

    /**
     * 删除用户
     * @param Status $status
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Status $status)
    {
        //判断删除用户是否是微博发布者id
        $this->authorize('destroy',$status);
        $status->delete();
        session()->flash('success',"微博被成功删除");
        return redirect()->back();
    }
}
