<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['code', 'name', 'phone', 'address', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public static function nextCode(): string
    {
        $last = static::max('id') ?? 0;

        return sprintf('C%04d', $last + 1);
    }
}
