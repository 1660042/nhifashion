<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheLoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('theloai')->insert([
            [
                'ten' => 'Đồ uống',
                'anh' => 'https://png.pngtree.com/png-clipart/20190516/original/pngtree-cartoon-cute-tea-drink-beverages-can-be-commercial-elements-teadrinkdrinkcartoonlovely-png-image_4076364.jpg',
            ],
            [
                'ten' => 'Ăn vặt',
                'anh' => 'https://png.pngtree.com/png-clipart/20190619/original/pngtree-food-delicious-snacks-hand-painted-features-delicious-food-png-image_3964096.jpg',
            ],
            [
                'ten' => 'Bánh',
                'anh' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR1y-O-_rUZ7hWm-0oJWQdUbeT3SBB9CXZ1iA&usqp=CAU',
            ],
        ]);
    }
}
