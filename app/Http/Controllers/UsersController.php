<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        //验证登录操作方法
        $this->middleware('auth',[
            'except'    => ['show','create','store','index']
        ]);
        //只允许未登录用户访问
        $this->middleware('guest',[
            'only'      => ['create']
        ]);
    }

    /**
     * 显示用户列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * 显示注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 显示用户和微博信息
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $statuses = $user->statuses()
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('users.show',compact('user','statuses'));
    }

    /**
     * 注册并登陆
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //数据验证
        $this->validate($request,[
            'name'      => 'required|max:50',
            'email'     => 'required|email|unique:users|max:255',
            'password'  => 'required|confirmed|min:6',
        ]);

        //添加注册信息
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
        ]);

        Auth::login($user);//让一个已认证通过的用户实例进行登录
        session()->flash('success',"欢迎，您将在这里开启一段新的旅程~");
        return redirect()->route('users.show',[$user]);
    }

    /**
     * 显示个人信息编辑页面
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    /**
     * 更新个人资料
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(User $user,Request $request)
    {

        $this->authorize('update', $user);//授权策略(判断是否是在更新自己的信息)
        //验证信息
        $this->validate($request,[
            'name'      => 'required|max:50',
            'password'  => 'nullable|confirmed|min:6',
        ]);

        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        //更新信息
        $user->update($data);

        session()->flash('success',"个人资料更新成功！");

        return redirect()->route('users.show',$user);

    }

    /**
     * 删除用户
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
