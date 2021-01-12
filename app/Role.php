<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{

	protected $fillable = ['name'];


    public function scopeWhenSearch($query, $search)
    {

    	return $query->when($search, function($q) use ($search) {
    		$q->where('name', 'like', "%$search%");
    	});

    }

    // get name attribute

    public function getNameAttribute($value)
    {

    	$result = str_replace('-', ' ', $value);

    	return ucwords($result);
    }

    //

    public function scopeWhereRoleNot($query, $role_name)
    {
    	return $query->whereNotIn('name', (array)$role_name);
    }


}
