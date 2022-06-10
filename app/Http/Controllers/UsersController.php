<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Image;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {

        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            // OSS图片上传
            // $folder = '/wsqtest';
            // $path = Storage::disk('oss')->putFile($folder, $request->avatar);
            // $imagePath = 'https://xxx.oss-cn-chengdu.aliyuncs.com/' . $path;
            // $data['avatar'] = $imagePath;

            $folder         = '/images';
            $imageName      = Storage::disk('public')->putFile($folder, $request->avatar);
            $imagePath      = 'http://larabbs.org/storage/' . $imageName;
            $data['avatar'] = $imagePath;
        }

        $user->update($data);


        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

    public function reduceSize($file_path, $max_width = 416)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
