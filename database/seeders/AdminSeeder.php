<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use function Deployer\timestamp;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $user =  User::query()->updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'name' => 'Berk Yıldız',
                'email' => 'yildizbrk@outlook.com.tr',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('@166_Wa9aa8')
            ]);

      $user->assignRole('Super Admin');
    }
}
