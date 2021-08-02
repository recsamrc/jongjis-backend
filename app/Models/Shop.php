<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;

class Shop extends Model
{
    use HasFactory, CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_shops';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

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
    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function bikes()
    {
        return $this->hasMany(Bike::class, 'shop_id');
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
    public function getCoverAttribute($value)
    {
        return $value ?  route('file.image', $value) : '';
    }

    public function getCoverPathAttribute()
    {
        $cover = $this->attributes['cover'];
        return $cover ? config('constants.image.dir.base') . '/' . $cover : '';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setCoverAttribute($value)
    {
        $disk = 'public';
        $destination_path = "shops";

        // if the image was erased
        if ($value == null) {
            Storage::disk($disk)->delete($this->cover);
            $this->attributes['cover'] = null;
        }

        if (Str::startsWith($value, 'data:image')) {
            $image = ImageManager::make($value)->encode('jpg', 90);
            $filename = md5($value . time()) . '.jpg';

            $imagePath = Storage::disk($disk)->put('images/' . $destination_path . '/' . $filename, $image->stream());
            Storage::disk($disk)->delete($this->cover_path);

            $this->attributes['cover'] = $destination_path . '/' . $filename;
        } else {
            $this->attributes['cover'] = $value;
        }
    }
}
