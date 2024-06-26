<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [

        "store_id",
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'stutas',
    ];

    protected static function booted()
    {
        static::addGlobalScope(StoreScope::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,      //related model
            'product_tag',   //pivot table
            'product_id',    //fk pivot table for the currant model
            'tag_id',        //fk pivot table for the related model
            'id',            //pk currant model
            'id',           //pk currant model
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('stutas', '=', 'active');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://navajeevan.websites.co.in/obaju-turquoise/img/product-placeholder.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price));
    }
}
