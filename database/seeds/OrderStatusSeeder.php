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
            ['name' => 'Pending', 'description' => ''],
            ['name' => 'Awaiting Payment', 'description' => ''],
            ['name' => 'Awaiting Fulfillment', 'description' => ''],
            ['name' => 'Awaiting Shipment', 'description' => ''],
            ['name' => 'Awaiting Pickup', 'description' => ''],
            ['name' => 'Partially Shipped', 'description' => ''],
            ['name' => 'Shipped', 'description' => ''],
            ['name' => 'Declined', 'description' => ''],
            ['name' => 'Refunded', 'description' => ''],
            ['name' => 'Canceled', 'description' => ''],
            ['name' => 'Disputed', 'description' => ''],
            ['name' => 'Partially Refunded ', 'description' => ''],
        ];
        foreach($status as $rec){
            OrderStatus::create($rec);
        }
    }
}
