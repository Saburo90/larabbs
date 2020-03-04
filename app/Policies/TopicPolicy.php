<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        // 更新帖子越权控制
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        // 删除帖子越权控制
        return $user->isAuthorOf($topic);
    }
}
