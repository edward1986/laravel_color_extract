<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Relationship
    public function item_images() {

        return $this->hasMany('App\Models\ItemImage', 'item_id', 'id');

    }

    public function item_image_colors() {

        return $this->hasMany('App\Models\ItemImageColor', 'item_id', 'id');

    }
}
