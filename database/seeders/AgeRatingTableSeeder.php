<?php

namespace Database\Seeders;

use createAgeRatingTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeRatingTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * @var array|\string[][]
     */
    protected array $data = [
        [
            'age'           => '17',
            'rating_factor' => '1.50'
        ], [
            'age'           => '18',
            'rating_factor' => '1.40'
        ], [
            'age'           => '19',
            'rating_factor' => '1.30'
        ], [
            'age'           => '20',
            'rating_factor' => '1.20'
        ], [
            'age'           => '21',
            'rating_factor' => '1.10'
        ], [
            'age'           => '22',
            'rating_factor' => '1.00'
        ], [
            'age'           => '23',
            'rating_factor' => '0.95'
        ], [
            'age'           => '24',
            'rating_factor' => '0.90'
        ], [
            'age'           => '25',
            'rating_factor' => '0.75'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(createAgeRatingTable::TABLE_NAME)->insert($this->data);
    }
}
