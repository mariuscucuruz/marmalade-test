<?php

namespace Database\Seeders;

use createAbiCodeRatingTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbiCodeRatingTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * @var array|\string[][]
     */
    protected array $data = [
        [
            'abi_code'      => '22529902',
            'rating_factor' => 0.95
        ], [
            'abi_code'      => '46545255',
            'rating_factor' => 1.15
        ], [
            'abi_code'      => '52123803',
            'rating_factor' => 1.20
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(createAbiCodeRatingTable::TABLE_NAME)->insert($this->data);
    }
}
