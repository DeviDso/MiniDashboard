<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;

class ImportController extends Controller
{
    public function products(Request $r){
      $csv = $r->file('csv_file');

      $file_handle = fopen($csv, 'r');
      $counter = 0;

      fgetcsv($file_handle);

      while (!feof($file_handle) ) {
         $line_of_text[] = fgetcsv($file_handle, 1024, ';');
         $counter++;
      }
      fclose($file_handle);

      foreach($line_of_text as $key => $item){
        $kodas = $item[2];
        $likutis = $item[3];
        // $kaina = str_replace(',', '.', $item[5]);
        // $temp = '';
        // for($i = 0; $i < strlen($kaina); $i++){
        //   if($kaina[$i] != 0){
        //     $temp = $temp . $kaina[$i];
        //   }
        // }
        $pavadinimas = $item[7];
        $kategorija = $item[8];

        if($item[2] != ''){
          $category = ProductCategory::where('code', $kategorija)->first();

          $product = Product::firstOrNew([
            'code' => $kodas,
          ]);

          $product->name = $pavadinimas;
          $product->quantity = $likutis;
          if($category){
            $product->category_id = $category->id;
          }
          // $product->price = $temp;
          $product->save();
        }
      }
        return response()->json('Atnaujinta: ' . $counter, 200);
    }
}
