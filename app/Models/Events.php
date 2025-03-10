<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'categories',
        'themes',
        'registration_start',
        'registration_end',
        'event_start',
        'event_end',
        'time',
        'estimated_visitors',
        'location',
        'city',
        'detailed_location',
        'company_profile_id'
    ];

    protected $casts = [
        'categories' => 'array',
        'themes' => 'array',
    ];

    // Mutator untuk menyimpan array sebagai JSON
    public function setCategoriesAttribute($value) {
        $this->attributes['categories'] = json_encode($value);
    }

    public function setThemesAttribute($value) {
        $this->attributes['themes'] = json_encode($value);
    }

    // Accessor untuk mengambil JSON sebagai array
    public function getCategoriesAttribute($value) {
        return json_decode($value, true);
    }

    public function getThemesAttribute($value) {
        return json_decode($value, true);
    }

    // Relasi ke CompanyProfile
    public function companyProfile() {
        return $this->belongsTo(CompanyProfile::class);
    }
}
