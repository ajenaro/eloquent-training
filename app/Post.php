<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['title', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Styde'
        ]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot(['featured'])
            ->withTimestamps();
    }

    public function addCategories(Category ...$categories)
    {
        $this->categories()->syncWithoutDetaching(new Collection($categories));
    }

    public function addFeaturedCategory(Category $category)
    {
        $this->categories()->detach($category);
        $this->categories()->attach($category, ['featured' => true]);
    }
}
