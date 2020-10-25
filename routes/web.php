<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('color_extract', function(){

    for($i = 1 ; $i <= 4 ; $i++) {

        $image_path = public_path('images/color_extract_'. $i .'.jpg');

        $item_image = new \App\Models\ItemImage();
        $item_image->item_id = $i;
        $item_image->path = $image_path;
        $item_image->save();

    }

});

Route::get('show_items', function(){

    $items = \App\Models\Item::with('item_image_colors')
        ->has('item_image_colors') // 色データがあるものだけ
        ->get();

    echo '<div style="text-align:center;">';

    foreach ($items as $item) {

        echo $item->name .'<br>';
        echo '<img style="height:150px;" src="/images/color_extract_'. $item->id .'.jpg"><br>';
        echo '色： '. $item->item_image_colors->pluck('color')->implode(', ');
        echo '<hr>';

    }

    echo '</div>';

});

Route::get('search_item_by_color', function(){

    $color = request('color');

    $items = \App\Models\Item::with('item_image_colors')
        ->when($color, function($query, $color){

            if(in_array($color, ['red', 'blue', 'yellow', 'green'])) {

                $query->whereHas('item_image_colors', function($q) use($color) {

                    $q->where('color', $color);

                });

            }

        })
        ->get();
    dd($items->toArray());

});

