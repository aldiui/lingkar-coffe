<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusBadgeAttribute()
    {
        return statusBadgePenjualan($this->attributes['status']);
    }

    public function getTglAttribute()
    {
        return formatTanggal($this->attributes['tanggal'], 'd M Y');
    }

}
