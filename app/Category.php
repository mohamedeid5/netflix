<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // attributes

    public function getNameAttribute($value)
    {
    	return ucfirst($value);
    }

    //scopes

    public function scopeWhenSearch($query, $search)
    {
    	return $query->when($search, function($q) use ($search){
    		$q->where('name', 'like', "%$search%");
    	});
    }

    // many to many relationship

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_category');
    }
}
