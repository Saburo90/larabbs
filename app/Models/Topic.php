<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 帖子与用户表关联关系
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 帖子与帖子分类表的关联关系
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
