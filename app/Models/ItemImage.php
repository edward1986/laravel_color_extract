<?php

namespace App\Models;

use App\Events\ItemImageSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'saved' => ItemImageSaved::class
    ];
}
