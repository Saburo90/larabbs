<?php
namespace App\Handlers;
use Illuminate\Support\Str;
use Image;

class ImageUploadHandler
{
    // 只允许以下后缀名图片上传
    protected $allowed_ext = ['jpg', 'png', 'gif', 'jpeg'];

    public function sava($file, $folder, $file_prefix, $max_width = false)
    {
        // 文件存储文件夹规则， 如：uploads/images/avatars/202003/03/
        // 文件夹切割能让查找效率更高
        $folder_name = "uploads/images/$folder/" . date('Ym/d', time());

        // 文件存储的绝对路径，如：/mnt/d/project/php/larabbs/public/uploads/images/avatars/202003/03/my-avatar.png
        $upload_path = public_path() . '/' . $folder_name;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png'; // php7新的三元运算符表达式

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID
        // 值如：1_1493521050_7BVc9v9ujP.png
        $file_name = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;

        if ( ! in_array($extension, $this->allowed_ext)) {
            // 不在允许上传文件格式列表中
            return false;
        }

        // 将图片移动到上传存储目录中
        $file->move($upload_path, $file_name);

        // 如果限制了图片的宽度，则进行裁剪
        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $file_name, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$file_name"
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 实例化
        $image = Image::make($file_path);
        // 大小调整
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 修改完成保存
        $image->save();
    }
}
