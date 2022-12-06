<?php

namespace Database\Seeders;

use App\Models\Info;
use App\Models\InfoTranslation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Info::create([
            'email' => 'infon@gmail.com',
            'mobile' => '05912345789',
            // 'f_name' => 'Info',
            // 'l_name' => 'Name',
            'birthdate' => Carbon::create('1999', '15', '12'),
            // 'location' => 'lorem epsum',
            'nationality' => 'Palestinian',
            'languages' => '["Arabic","English"]',
            'experience' => '2',
            'freelance_active' => false,
            'facebook_url' => 'https://www.facebook.com/sawsan.s.ghabayen/',
            'skybe' => 'https://www.facebook.com/sawsan.s.ghabayen/',
            'twitter_url' => 'https://www.facebook.com/sawsan.s.ghabayen/',
            'dribbble' => 'https://www.facebook.com/sawsan.s.ghabayen/',
            'youtube_url' => 'https://www.facebook.com/sawsan.s.ghabayen/',
            // 'job' => 'Laravel PHP',
            'image' => '',
            'cv' => '',
            
        ]);
        InfoTranslation::create([
           
            'f_name' => 'sawsan',
            'l_name' => 'ghabayen',
            'location' => 'lorem epsum',
            'locale' => 'en',
            'info_id' => '1',
            'job' => 'Laravel PHP',
           
            
        ]);
        InfoTranslation::create([
           
            'f_name' => 'سوسن',
            'l_name' => 'غباين',
            'location' => 'صضثصثق',
            'locale' => 'ar',
            'info_id' => '1',
            'job' => 'لارافيل ',
           
            
        ]);
    }
}
