<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusBadgeAttribute()
    {
        return statusBadge($this->attributes['status']);
    }

    public function getTglAttribute()
    {
        return formatTanggal($this->attributes['tanggal']);
    }
}