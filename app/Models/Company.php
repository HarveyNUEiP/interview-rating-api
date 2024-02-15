<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'principal'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'status'
    ];

    /**
     * Define the relationship with the comments table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a builder to only include companies with a given name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName(Builder $builder, string $name): Builder
    {
        return $builder->where('name', 'LIKE', "%$name%");
    }

    /**
     * Scope a builder to include the most recent comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMostRecentComment(Builder $builder): Builder
    {
        return $builder->withMax('comments', 'updated_at');
    }
}
