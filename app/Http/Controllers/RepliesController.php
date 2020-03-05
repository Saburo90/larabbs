<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;
use function GuzzleHttp\Psr7\parse_query;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	/*public function index()
	{
		$replies = Reply::paginate();
		return view('replies.index', compact('replies'));
	}

    public function show(Reply $reply)
    {
        return view('replies.show', compact('reply'));
    }

	public function create(Reply $reply)
	{
		return view('replies.create_and_edit', compact('reply'));
	}*/

	public function store(ReplyRequest $request, Reply $reply)
	{
	    // Reply空模型赋值
        $request_data = parse_query($request->content);
		$reply->content = $request_data['content'];
		$reply->user_id = Auth::id();
		$reply->topic_id = $request->topic_id;
        // 空模型赋值完成后保存入库
		$reply->save();
		return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
	}

	/*public function edit(Reply $reply)
	{
        $this->authorize('update', $reply);
		return view('replies.create_and_edit', compact('reply'));
	}

	public function update(ReplyRequest $request, Reply $reply)
	{
		$this->authorize('update', $reply);
		$reply->update($request->all());

		return redirect()->route('replies.show', $reply->id)->with('message', 'Updated successfully.');
	}*/

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->to($reply->topic->link())->with('success', '评论删除成功！');
	}
}
