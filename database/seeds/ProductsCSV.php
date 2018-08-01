<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
use App\Product;

class ProductsCSV extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = public_path().'/prekes.csv';

        function readCSV($csvFile){
            $file_handle = fopen($csvFile, 'r');
            while (!feof($file_handle) ) {
                $line_of_text[] = fgetcsv($file_handle, 1024);
            }
            fclose($file_handle);
            return $line_of_text;
        }

        $csv = readCSV($csv);

        foreach($csv as $item){
           $cat = ProductCategory::where('code', $item[2])->first();

           Product::create([
             'name' => $item[1],
             'category_id' => $cat->id,
             'code' => $item[0],
             'quantity' => 1,
             'warehouse' => 1,
             'bruto' => 0.00,
             'netto' => 0.00,
          ]);
        }


        // $this->info($csv);
    }
}
