<?php

namespace App\Models;

use App\Models\HargaJual;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPokok extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hargaJuals()
    {
        return $this->hasMany(HargaJual::class, 'harga_pokok_id');
    }

    public function getHargaAttribute()
    {
        return $this->attributes['harga_pokok'] + $this->attributes['keuntungan'] + $this->attributes['insentif'];
    }
}
