<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ImageResource;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, Image $image)
    {
        $user = $request->user();

        $folder    = '/images';
        $imageName = Storage::disk('public')->putFile($folder, $request->image);
        $path      = 'http://larabbs.org/storage/' . $imageName;

        $image->path    = $path;
        $image->type    = $request->type;
        $image->user_id = $user->id;
        $image->save();

        return new ImageResource($image);
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
