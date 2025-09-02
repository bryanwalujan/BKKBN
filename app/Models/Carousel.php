<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $fillable = [
        'sub_heading',
        'heading',
        'deskripsi',
        'button_1_text',
        'button_1_link',
        'button_2_text',
        'button_2_link',
        'gambar',
    ];
}