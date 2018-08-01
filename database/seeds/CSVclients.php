<?php

use Illuminate\Database\Seeder;
use App\Client;

class CSVclients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $csv = public_path().'/klientai.csv';

     function readCSV($csvFile){
          $file_handle = fopen($csvFile, 'r');
          while (!feof($file_handle) ) {
             $line_of_text[] = fgetcsv($file_handle, 1024, ';');
          }
          fclose($file_handle);
          return $line_of_text;
     }

     $csv = readCSV($csv);

     foreach($csv as $key => $item){
           Client::create([
             'name' => $item[1],
             'registration_id' => $item[2],
             'vat_status' => $item[3],
             'vat' => $item[4],
             'street' => $item[5],
             'city' => $item[6],
             'post_code' => $item[7],
             'street' => $item[5],
             'country' => $item[9],
             'phone' => $item[10],
             'email' => $item[12],
             'contact_person' => $item[14],
             'contact_person_phone' => $item[15],
          ]);

       echo "New client: #" .$key."\n";
     }
    }
}
