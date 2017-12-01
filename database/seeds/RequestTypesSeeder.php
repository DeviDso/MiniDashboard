<?php

use Illuminate\Database\Seeder;
use App\RequestType;

class RequestTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Item request'],
            ['name' => 'Supply request'],
            ['name' => 'Warranty request'],
            ['name' => 'Contact request'],
        ];
        foreach($status as $rec){
            RequestType::create($rec);
        }
    }
}
