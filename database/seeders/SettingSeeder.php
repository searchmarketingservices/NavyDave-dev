<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'app_name' => 'NAVY DAVE GOLF',
            'logo' => 'logo/DtBXrzK7cxK9PuygF5VSMUbcZhT57SfyimhYtugp.png',
            'phone' => '+1 (480) 238-4724',
            'location' => '123 Main St, Anytown USA 12345',
            'footer_description' => 'Navy Dave, with 30 years of golf experience, believes in cultivating your unique perfect swing.',
            'email' => 'navydavegolf@gmail.com',
            'copyright' => '© 2023 NAVY DAVE GOLF. All rights reserved.',
            'facebook_link' => 'https://www.facebook.com/',
            'twitter_link' => 'https://twitter.com/',
            'instagram_link' => 'https://www.instagram.com/',
            'linkedin_link' => 'https://www.linkedin.com/',
        ]);
    }
}
