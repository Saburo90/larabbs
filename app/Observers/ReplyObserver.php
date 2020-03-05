<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function created(Reply $reply)
    {
        // 利用Reply的动态属性topic对topic表中的reply_count赋值
        /*$reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();*/
        $reply->topic->updateReplyCount();

        // 通知帖子的作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        // 减去话题回复数
        /*$reply->topic->reply_count = $reply->topic->replies()->count();
        $reply->topic->save();*/
        $reply->topic->updateReplyCount();
    }
}
