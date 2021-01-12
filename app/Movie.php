<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rate',
        'year',
        'path',
        'poster',
        'images',
        'percent'
    ];

    protected $appends = ['poster_path', 'image_path', 'is_favored'];

    // attributes

    public function getPosterPathAttribute()
    {
        return Storage::url('images/' . $this->poster);
    }

    public function getImagePathAttribute()
    {
        return Storage::url('images/' . $this->images);
    }

    // check if user favored this movie

    public function getIsFavoredAttribute()
    {
        if(auth()->user()){

            return (bool)$this->users()->where('user_id', auth()->user()->id)->count();
        }

        return false;
    }

    // scopes

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('year', 'like', "%$search%")
              ->orWhere('rate', 'like', "%$search%");
        });
    }

    // when category

    public function scopeWhenCategory($query, $category)
    {

          return $query->when($category, function ($q) use ($category) {

              return $q->whereHas('categories', function ($qu) use ($category) {

                  return  $qu->whereIn('category_id', (array)$category)
                             ->orWhereIn('name', (array)$category);

              });

            });

    }

    public function scopeWhenFavorite($query, $favorites)
    {
        return $query->when($favorites, function ($q) {

            return $q->whereHas('users', function ($qu) {

                return $qu->where('user_id', auth()->user()->id);

            });

        });
    }

    // relations

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_movie');
    }
}
