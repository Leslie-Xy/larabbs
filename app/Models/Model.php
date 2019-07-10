<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

    public function clearXss($model, array $column)
    {
        foreach ($column as $value){
            $model->$value = clean($model->$value, 'user_topic_body');
        }
    }

}
