<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['code', 'description', 'price'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
