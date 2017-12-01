<?php

use Illuminate\Database\Seeder;
use App\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Requested', 'description' => ''],
            ['name' => 'In progress', 'description' => ''],
            ['name' => 'Done', 'description' => ''],
            ['name' => 'Canceled', 'description' => ''],
        ];
        foreach($status as $rec){
            OrderStatus::create($rec);
        }
    }
}
