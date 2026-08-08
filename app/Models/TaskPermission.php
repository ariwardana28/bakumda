<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPermission extends Model
{
    protected $table = 'task_permission';

    protected $fillable = [
        'task_id',
        'permission_id',
    ];
}
