<?php

use Illuminate\Database\Seeder;

class IndustriesTableSeeder extends Seeder
{
	protected $industries = [
		'Agriculture',
		'Media & Advertising',
		'Construction',
		'Consulting',
		'Real Estate',
		'Legal Services',
		'Financial Services',
		'Travel/Hospitality',
		'Art & Design',
		'Education',
		'Engineering',
		'Financial Services',
		'Entertainment',
		'Non-profit',
		'Others',
		'Technology',
		'Software Development',
		'Services',
		'Health Care',
		'Manufacturing'
	];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->industries as $industry) {
        	DB::table('industries')->insert([
        		'name' => $industry,
        		'slug' => str_slug($industry, '-')
        	]);
        }
    }
}
