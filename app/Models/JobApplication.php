<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\JobApplication
 *
 * @property int $id
 * @property int $job_id
 * @property int $user_id
 * @property string $applicant_name
 * @property string $applicant_phone
 * @property string $applicant_email
 * @property string $applicant_address
 * @property string|null $cover_letter
 * @property string|null $experience
 * @property string|null $skills
 * @property string|null $cv_file_path
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Job $job
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication pending()
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereApplicantAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereApplicantEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereApplicantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereApplicantPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereCoverLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereCvFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobApplication whereUserId($value)
 * @method static \Database\Factories\JobApplicationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'job_id',
        'user_id',
        'applicant_name',
        'applicant_phone',
        'applicant_email',
        'applicant_address',
        'cover_letter',
        'experience',
        'skills',
        'cv_file_path',
        'status',
        'notes',
        'reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the job this application is for.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user who submitted this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}