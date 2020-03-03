<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        // 登录权限控制
        $this->middleware('auth', [
            'except' => ['show']
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // 越权操作控制
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        // 越权操作控制
        $this->authorize('update', $user);

        $data = $request->all();

        // 用户修改了头像
        if ($request->avatar) {
            $change_avatar_res = $uploader->sava($request->avatar, 'avatars', $user->id, 416);
            if ($change_avatar_res) {
                $data['avatar'] = $change_avatar_res['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
