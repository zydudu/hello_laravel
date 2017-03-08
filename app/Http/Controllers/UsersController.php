<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;
class UsersController extends Controller
{
    //
 public function __construct()
    {
        $this->middleware('auth', [            
'only' => ['edit', 'update', 'destroy', 'followings', 'followers']        
]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
 public function index()
    {
$users = User::paginate(30);
        return view('users.index', compact('users'));
    }
public function create()
    {
        return view('users.create');
    }
public function show($id)
    {
        $user = User::findOrFail($id);
 $statuses = $user->statuses()
                           ->orderBy('created_at', 'desc')
                           ->paginate(30);
        return view('users.show', compact('user', 'statuses'));    
}
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'confirmed|min:6'
        ]);

        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', 'Update successfully!');

        return redirect()->route('users.show', $id);
    }
public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Delete successfully!');
        return back();
    }
 public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'Verify email has been sent to your registered email, please check.');
        //验证邮件已发送到你的注册邮箱上，请注意查收。
        return redirect('/');
    }

protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '87826632@qq.com';
        $name = 'SadCreeper';
        $to = $user->email;
        $subject = "Thank you for registering! Please confirm your email address";
        //感谢注册 Sample 应用！请确认你的邮箱。

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Activation success!');
        //激活成功！
        return redirect()->route('users.show', [$user]);
    }
 public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(30);
        $title = 'Followings List';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(30);
        $title = 'Followers List';
        return view('users.show_follow', compact('users', 'title'));
    }
}
