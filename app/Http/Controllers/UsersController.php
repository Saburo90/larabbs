<?php

namespace App\Http\Controllers;
use App\Handlers\ImageUploadHandler;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        // 用户修改了头像
        if ($request->avatar) {
            $change_avatar_res = $uploader->sava($request->avatar, 'avatars', $user->id);
            if ($change_avatar_res) {
                $data['avatar'] = $change_avatar_res['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
