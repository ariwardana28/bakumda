<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission;

class Task extends Model
{
    protected $table = 'task';

    protected $fillable = [
        'name',
    ];

    /**
     * The permissions that belong to the task.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'task_permission', 'task_id', 'permission_id');
    }
}
