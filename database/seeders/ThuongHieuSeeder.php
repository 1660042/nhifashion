<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThuongHieuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thuonghieu')->insert([
            [
                'ten' => 'Lá Food',
                'anh' => 'https://images.foody.vn/res/g81/800131/prof/s576x330/foody-upload-api-foody-mobile-4feb21ad425aa004f94b-190325085546.jpg',
                'mota' => 'Siêu đình đám',
                'diachi' => '2 Khánh An 5,  Quận Liên Chiểu, Đà Nẵng',
            ],
            [
                'ten' => 'BONPAS BAKERY & COFFEE',
                'anh' => 'http://bonpasbakery.com/image/data/logo/logo_bonpas_fa_newc.png',
                'mota' => 'Bản quyền thuộc về BonPas Bakery & Coffee. Phát triển bởi Kovo',
                'diachi' => '35-37-39-41 Nguyễn Văn Linh - P.Bình Hiên - Q.Hải Châu - TP. Đà Nẵng',
            ],
            [
                'ten' => 'Sasin',
                'anh' => 'http://micaysasin.vn/upload/hinhanh/logo-2662-84690.png',
                'mota' => 'Sasin Mì Cay 7 Cấp Độ Hàn Quốc',
                'diachi' => 'Email: dotuan@sasin.vn hoặc ngoc.le@sasin.vn'
            ],
        ]);
    }
}
