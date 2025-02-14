<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminObj = new User();
        $adminObj->name = 'Admin';
        $adminObj->email = 'admin@admin.com';
        $adminObj->password = Hash::make('admin12345');
        $adminObj->user_type = 'admin';
        $adminObj->mobile = '9876543210';
        $adminObj->save();
    }
}
