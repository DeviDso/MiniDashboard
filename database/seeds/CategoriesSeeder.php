<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Hidrauliniai siurbliai', 'code' => 'HS'],
            ['name' => 'Hidrauliniu siurbliu dalys', 'code' => 'HHS'],
            ['name' => 'Korea dalys', 'code' => 'DK'],
            ['name' => 'Varikliu dalys', 'code' => 'VD'],
            ['name' => 'Vaziuokles dalys', 'code' => 'RVD'],
            ['name' => 'Viksrines vaziuokles dalys', 'code' => 'VVD'],
            ['name' => 'Reduktoriai ir dalys', 'code' => 'RD'],
            ['name' => 'Kaisciai ir ivores', 'code' => 'KID'],
            ['name' => 'Z.u technikos dalys', 'code' => 'ZU'],
            ['name' => 'Kitos dalys', 'code' => 'KD'],
        ];

        foreach($categories as $category){
            ProductCategory::create($category);
        }
    }
}
