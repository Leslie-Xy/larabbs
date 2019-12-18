<?php

namespace App\Observers;

use App\Models\Topic;
use Leslie\elasticsearch\Repository\ElasticSearch\ElasticSearchModel;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        $topic->clearXss($topic, ['body']);
    }

    public function created(Topic $topic)
    {
        $esModel = with(new ElasticSearchModel('topics', 'Course'));
        $esModel->create([
            'id' => $topic->id,
            'title' => $topic->title,
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'created_at' => time(),
            'updated_at' => time(),
        ],'id');
    }

    public function saving(Topic $topic)
    {
        $topic->clearXss($topic, ['body']);
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
