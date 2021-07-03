<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;

class Bike extends Model
{
    use HasFactory, CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_bikes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'bike_name', 'description', 'weight', 'height', 'rent_price', 'availability',
        'bike_category_id', 'shop_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $attributes = [
        'bike_name' => '',
        'description' => '',
        'weight' => '',
        'height' => '',
        'rent_price' => '',
        'availability' => true,
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(BikeCategory::class, 'bike_category_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'related_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getFeatureImageUrlAttribute()
    {
        $featureImage = $this->images()->where('is_featured', true)->first();
        if ($featureImage == null)
            $featureImage = $this->images()->first();
        
        $featureImageUrl = '';
        if ($featureImage != null)
            $featureImageUrl = $featureImage->file;
        return $featureImageUrl;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
