<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $website_data = new Website();
        $website_data->site_logo = 'noimage.jpg';
        $website_data->site_name = 'thennarasu';
        $website_data->site_email = 'test@test.com';
        $website_data->site_mobile = '9876543210';
        $website_data->site_desc = 'test';
        $website_data->site_address_line1 = 'address_line_1';
        $website_data->site_address_line2 = 'address_line_2';
        $website_data->site_address_city = 'address_city';
        $website_data->site_address_state = 'address_state';
        $website_data->site_address_pincode = '123456';
        $website_data->save();
    }
}
