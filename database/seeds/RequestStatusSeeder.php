<?php

use Illuminate\Database\Seeder;
use App\RequestStatus;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'In progress'],
            ['name' => 'Done'],
            ['name' => 'Canceled'],
        ];
        foreach($status as $rec){
            RequestStatus::create($rec);
        }
    }
}
