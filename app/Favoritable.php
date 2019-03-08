<?php


namespace App;


trait Favoritable
{

    protected static function bootFavoritable()
    {
        static::deleting(function($model) {
            $model->favorites->each(function ($favorite) {
                $favorite->delete();
            });
        });
    }


    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->delete();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}