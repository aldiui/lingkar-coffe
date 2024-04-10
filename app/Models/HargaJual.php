<?php

namespace App\Models;

use App\Models\HargaPokok;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaJual extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hargaPokok()
    {
        return $this->belongsTo(HargaPokok::class, 'harga_pokok_id');
    }
}