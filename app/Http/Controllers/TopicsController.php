<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
	    // 解决N+1问题
		$topics = $topic->WithOrder($request->order)
            ->with('user', 'category') // 解决N+1问题
            ->paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    // 获取所有帖子分类
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
		$topic->user_id =  Auth::id();
		$topic->save();
		return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回json数据, 默认上传失败
        $data = [
            'success' => false,
            'msg' => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否有文件上传，并赋值给$file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->sava($file, 'topics', Auth::id(), 1024);

            // 图片保存成功
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['success'] = true;
                $data['msg'] = '上传成功！';
            }
        }
        return $data;
	}
}
