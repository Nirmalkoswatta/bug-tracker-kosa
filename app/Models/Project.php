<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];

    public function bugs(): HasMany
    {
        return $this->hasMany(Bug::class);
    }
}
