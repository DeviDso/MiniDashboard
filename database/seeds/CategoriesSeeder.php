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
            ['name' => 'Hidrauliniai siurbliai  HS'],
            ['name' => 'Hidrauliniu siurbliu dalys HSS'],
            ['name' => 'Korea dalys DK'],
            ['name' => 'Varikliu dalys VD'],
            ['name' => 'Vaziuokles dalys RVD'],
            ['name' => 'Viksrines vaziuokles dalys VVD'],
            ['name' => 'Reduktoriai ir dalys RD'],
            ['name' => 'Kaisciai ir ivores KID'],
            ['name' => 'Z.u technikos dalys ZU'],
            ['name' => 'Kitos dalys  KD'],
        ];

        foreach($categories as $category){
            ProductCategory::create($category);
        }
    }
}
