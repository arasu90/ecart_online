<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Website::insert([
            'site_logo' => 'image.jpg',
            'site_address' => 'Dharmapuri',
            'site_desc' => '',
            'site_email' => 'mail@mail.com',
            'site_mobile' => '9876543210',
        ]);
    }
}
