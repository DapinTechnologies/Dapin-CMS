<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            ['title' => 'Faculty of Arts and Social Sciences', 'shortcode' => 'FASS'],
            ['title' => 'Faculty of Science and Technology', 'shortcode' => 'FST'],
            ['title' => 'Faculty of Education', 'shortcode' => 'FED'],
            ['title' => 'Faculty of Engineering and Technology', 'shortcode' => 'FET'],
            ['title' => 'Faculty of Agriculture', 'shortcode' => 'FAG'],
            ['title' => 'Faculty of Law', 'shortcode' => 'FLAW'],
            ['title' => 'Faculty of Medicine and Health Sciences', 'shortcode' => 'FMHS'],
            ['title' => 'Faculty of Veterinary Medicine', 'shortcode' => 'FVM'],
            ['title' => 'Faculty of Built Environment and Design', 'shortcode' => 'FBED'],
            ['title' => 'Faculty of Business and Management Sciences', 'shortcode' => 'FBMS'],
            ['title' => 'Faculty of Computing and Informatics', 'shortcode' => 'FCI'],
            ['title' => 'Faculty of Environmental Studies', 'shortcode' => 'FES'],
            ['title' => 'Faculty of Theology and Religious Studies', 'shortcode' => 'FTRS'],
            ['title' => 'Faculty of Economics', 'shortcode' => 'FECO'],
            ['title' => 'Faculty of Hospitality and Tourism Management', 'shortcode' => 'FHTM'],
            ['title' => 'Faculty of Nursing', 'shortcode' => 'FON'],
            ['title' => 'Faculty of Music and Performing Arts', 'shortcode' => 'FMPA'],
        ];

        foreach ($faculties as $faculty) {
            DB::table('faculties')->insert([
                'title' => $faculty['title'],
                'slug' => Str::slug($faculty['title']),
                'shortcode' => $faculty['shortcode'],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
