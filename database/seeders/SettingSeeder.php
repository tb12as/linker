<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s = Setting::where('name', 'Hide private link')->first() ?? new Setting();
        $s->name = 'Hide private link';
        $s->key = 'hide_private_link';
        $s->type = 'boolean';
        $s->save();
    }
}
