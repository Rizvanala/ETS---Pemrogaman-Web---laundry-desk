<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $fillable = ['bill_id', 'user_id', 'status', 'changed_at'];

    protected function casts(): array
    {
        return ['changed_at' => 'datetime'];
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function clerk()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
