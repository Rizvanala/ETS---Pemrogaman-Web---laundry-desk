<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public const STATUS_FLOW = [
        'received' => 'finished',
        'finished' => 'collected',
    ];

    protected $fillable = [
        'code', 'customer_id', 'service_id', 'outlet_id', 'user_id',
        'arrived_at', 'unit', 'total', 'status',
    ];

    protected function casts(): array
    {
        return [
            'arrived_at' => 'datetime',
            'total' => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function clerk()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(StatusLog::class);
    }

    public function amountPaid(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function balance(): float
    {
        return (float) $this->total - $this->amountPaid();
    }

    public function nextStatus(): ?string
    {
        return self::STATUS_FLOW[$this->status] ?? null;
    }

    public static function nextCode(): string
    {
        $last = static::max('id') ?? 0;

        return sprintf('B%04d', $last + 1);
    }
}
