<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        // 获取当前分类下的帖子
        $topics = Topic::where('category_id', $category->id)->paginate(20);

        // 展示页面
        return view('topics.index', compact('topics', 'category'));
    }
}
