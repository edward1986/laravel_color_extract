<?php

namespace App\Events;

use App\Models\ItemImage;
use App\Models\ItemImageColor;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;

class ItemImageSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const THRESHOLD = 20; // 何％以上色があれば保存するか
    const BASE_COLORS = [ // 基準となる色
        'red' => [128, 0, 0],
        'blue' => [0, 0, 128],
        'yellow' => [128, 128, 0],
        'green' => [0, 128, 0],
        'black' => [0, 0, 0],
        'gray' => [128, 128, 128],
        'white' => [255, 255, 255]
    ];

    public function __construct(ItemImage $item_image)
    {
        $path = $item_image->path;
        $palette = Palette::fromFilename($path);
        $all_color_count = 0;
        $extracted_color_counts = [
            'red' => 0,
            'blue' => 0,
            'yellow' => 0,
            'green' => 0,
        ];

        foreach($palette as $color => $count) {

            $extracted_rgb = array_values(
                Color::fromIntToRgb($color)
            );
            $min_distance = 765; // 最大距離からスタート
            $color_key = '';

            foreach(self::BASE_COLORS as $key => $rgb) {

                $color_distance = $this->getColorDistance($extracted_rgb, $rgb);

                if($color_distance < $min_distance) {

                    $min_distance = $color_distance;
                    $color_key = $key;

                }

            }

            if(in_array($color_key, ['red', 'blue', 'yellow', 'green'])) {

                $extracted_color_counts[$color_key] += $count;
                $all_color_count += $count;

            }

        }

        foreach($extracted_color_counts as $color_key => $count) {

            if($count > 0 && in_array($color_key, ['red', 'blue', 'yellow', 'green'])) {

                $percentage = $count / $all_color_count * 100;

                if($percentage > self::THRESHOLD) { // しきい値より大きければ保存する

                    $item_image_color = new ItemImageColor();
                    $item_image_color->item_id = $item_image->item_id;
                    $item_image_color->item_image_id = $item_image->id;
                    $item_image_color->color = $color_key;
                    $item_image_color->save();

                }

            }

        }

    }

    function getColorDistance($color_1, $color_2) { // ２つの色がどれだけ離れているかを取得

        return abs($color_1[0] - $color_2[0]) +
            abs($color_1[1] - $color_2[1]) +
            abs($color_1[2] - $color_2[2]);

    }

}
