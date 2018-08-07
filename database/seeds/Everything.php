<?php

use Illuminate\Database\Seeder;

class Everything extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'David',
            'email' => 'dsadeckas@gmail.com',
            'password' => bcrypt('asdasd'),
            'api_token' => str_random(60),
        ]);

        $this->call(WarehouseSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(OrderStatusSeeder::class);
        // $this->call(ClientsCsv::class);
        // $this->call(ProductCsv::class);
        $this->call(RequestStatusSeeder::class);
        $this->call(RequestTypesSeeder::class);

        // factory(App\User::class, 10)->create();
        // factory(App\Client::class, 30)->create();
        // factory(App\ClientRequest::class, 300)->create();
        // factory(App\Product::class, 100)->create();
        // factory(App\Order::class, 100)->create();
        // factory(App\OrderData::class, 300)->create();
    }
}
