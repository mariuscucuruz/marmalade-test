<?php

namespace Database\Seeders;

use createPostcodeRatingTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostcodeRatingTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * @var array|\string[][]
     */
    protected array $data = [
        [
            'postcode_area' => 'LE10',
            'rating_factor' => '1.35'
        ], [
            'postcode_area' => 'PE3',
            'rating_factor' => '1.10'
        ], [
            'postcode_area' => 'WR2',
            'rating_factor' => '0.90'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(createPostcodeRatingTable::TABLE_NAME)->insert($this->data);
    }
}
