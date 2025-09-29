<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bug extends Model
{
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'created_by',
        'assigned_to',
        'status',
        'reviewed_by',
        'pm_id',
    ];
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function pm()
    {
        return $this->belongsTo(User::class, 'pm_id');
    }
}
