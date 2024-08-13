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
     * Added by Kalaiarasu for setting up default Users
     */
    public function run(): void
    {
        $userObj = new User();
        $userObj->name = 'User';
        $userObj->email = 'user@user.com';
        $userObj->password = Hash::make('user12345');
        $userObj->type = 'user';
        $userObj->save();

        $adminObj = new User();
        $adminObj->name = 'Admin';
        $adminObj->email = 'admin@admin.com';
        $adminObj->password = Hash::make('admin54321');
        $adminObj->type = 'admin';
        $adminObj->save();
    }
}
