<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        // XSS 过滤(HTMLpurifier)
        $topic->body = clean($topic->body, 'user_topic_body');
        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }
}
