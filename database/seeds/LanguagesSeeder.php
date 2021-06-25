<?php

use App\Language;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create language
        Language::create([
            'label' => 'English',
            'code' => 'en',
            'locale' => 'en_GB',
            'activated_at' => Carbon::now()
        ]);
    }
}
