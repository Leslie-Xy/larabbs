<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        $topic->clearXss($topic, ['title', 'body']);
    }

    public function saving(Topic $topic)
    {
        $topic->clearXss($topic, ['title', 'body']);
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}