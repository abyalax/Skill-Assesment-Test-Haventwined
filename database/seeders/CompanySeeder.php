<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        CompanyProfile::create([
            'name' => 'Haventwined',
            'description' => 'Haventwined adalah solusi inovatif untuk pengelolaan event, menghubungkan penyelenggara dengan tenant dan vendor terbaik di industri. Kami hadir untuk mengubah setiap momen spesial Anda menjadi kenangan yang tak terlupakan melalui perencanaan yang cermat, kreativitas tanpa batas, dan eksekusi yang profesional',
            'email' => 'support@haventwined.com',
            'whatsapp' => '082299449708',
            'banner' => json_encode([
                "https://res.cloudinary.com/dllhxulpv/image/upload/v1740306832/Screenshot_2025-02-23_170210_hjztzf.png",
                "https://res.cloudinary.com/dllhxulpv/image/upload/v1740306832/Screenshot_2025-02-23_170158_bvxrjn.png",
                "https://res.cloudinary.com/dllhxulpv/image/upload/v1740329253/haventwined/z9mu5t7fqeaauoahwtg6.png"
            ]),
            'location' => 'Jl. Boulevard Raya Gading Serpong, Kabupaten Tangerang ',
            'selected' => true
        ]);
    }
}
