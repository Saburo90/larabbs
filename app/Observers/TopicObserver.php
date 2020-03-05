<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
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

    public function saved(Topic $topic)
    {
        // 如果话题slug字段无内容，则使用翻译器对 title进行翻译
        if (!$topic->slug) {
//            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            // 推送任务到翻译slug队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        // 删除帖子的同时连同该帖下所有的回复一起删除
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
