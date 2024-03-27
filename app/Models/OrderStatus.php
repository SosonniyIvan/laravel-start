<?php

namespace App\Models;

use App\Enums\OrderStatus as Status;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $casts = [
        'name' => \App\Enums\OrderStatus::class
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $this->statusQuery($query, Status::InProcess);
    }
    public function scopePaid(Builder $query): Builder
    {
        return $this->statusQuery($query, Status::Paid);
    }
    public function scopeCanceled(Builder $query): Builder
    {
        return $this->statusQuery($query, Status::Canceled);
    }
    public function scopeComplete(Builder $query): Builder
    {
        return $this->statusQuery($query, Status::Completed);
    }
    public function name(): Attribute
    {
        return Attribute::get(fn() => $this->name->value);
    }

    protected function statusQuery(Builder $query, Status $status): Builder
    {
        return $query->where('name', $status->value);
    }
}
