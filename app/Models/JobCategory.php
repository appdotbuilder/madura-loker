<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\JobCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Job> $jobs
 * @property-read int|null $jobs_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobCategory whereUpdatedAt($value)
 * @method static \Database\Factories\JobCategoryFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class JobCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all jobs in this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}