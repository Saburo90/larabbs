<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, User $user, Link $link)
    {
        // 获取当前分类下的帖子
        $topics = $topic->withOrder($request->order)
            ->with('user', 'category')
            ->where('category_id', $category->id)
            ->paginate(30);

        // 获取活跃用户
        $active_users = $user->getActiveUsers();
        // 获取资源链接
        $links = $link->getAllCached();
        // 展示页面
        return view('topics.index', compact('topics', 'category', 'active_users', 'links'));
    }
}
