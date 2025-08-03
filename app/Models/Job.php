<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Job
 *
 * @property int $id
 * @property int $user_id
 * @property int $job_category_id
 * @property string $title
 * @property string $description
 * @property string $store_name
 * @property string $store_address
 * @property string $store_phone
 * @property float|null $salary_min
 * @property float|null $salary_max
 * @property string $salary_type
 * @property string|null $requirements
 * @property string|null $benefits
 * @property string $work_type
 * @property int $positions_available
 * @property \Illuminate\Support\Carbon|null $application_deadline
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\JobCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobApplication> $applications
 * @property-read int|null $applications_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job active()
 * @method static \Illuminate\Database\Eloquent\Builder|Job published()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereApplicationDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereJobCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePositionsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereSalaryMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereSalaryMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereSalaryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStoreAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStoreName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereStorePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereWorkType($value)
 * @method static \Database\Factories\JobFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'job_category_id',
        'title',
        'description',
        'store_name',
        'store_address',
        'store_phone',
        'salary_min',
        'salary_max',
        'salary_type',
        'requirements',
        'benefits',
        'work_type',
        'positions_available',
        'application_deadline',
        'status',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'positions_available' => 'integer',
        'application_deadline' => 'date',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who posted this job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * Get all applications for this job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope a query to only include active jobs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include published jobs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
}