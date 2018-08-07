<?php

use Illuminate\Database\Seeder;
use App\Warehouse;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Main'],
            // ['name' => 'Telšiai'],
        ];
        foreach($status as $rec){
            Warehouse::create($rec);
        }
    }
}
