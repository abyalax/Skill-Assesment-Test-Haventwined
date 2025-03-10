<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Events;

class CompanyProfile extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'email',
        'whatsapp',
        'banner',
        'selected'
    ];

    // Casting field banner menjadi array
    protected $casts = [
        'banner' => 'array',
        'selected' => 'boolean'
    ];


    public function setBannerAttribute($value) {
        $this->attributes['banner'] = json_encode($value);
    }

    // Accessor untuk mengambil JSON sebagai array
    public function getBannerAttribute($value) {
        return json_decode($value, true);
    }

    // Relasi one-to-many: satu company profile memiliki banyak event
    public function events() {
        return $this->hasMany(Events::class);
    }
}
