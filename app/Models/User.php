<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'role','name','firstname','email','password',
        'phone','city','profile_photo','profile_banner','cv',
        'about','expected_salary',
        'company_name','siret','recruitment_description',
        'team_description','description','logo','website_url', 'is_verified', 'is_admin',
    ];

    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'experience_years' => 'integer',
        'expected_salary'  => 'integer',
        'email_verified_at'=> 'datetime',
        'is_verified'      => 'boolean',
        'is_admin'         => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->id = (string) Str::uuid());
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)
                    ->withTimestamps()
                    ->using(SkillUser::class)
                    ->withPivot('id');
    }

    public function essentialKnowledge()
    {
        return $this->hasOne(EssentialKnowledge::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class)
                    ->using(LanguageUser::class)
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function educationLevels()
    {
        return $this->belongsToMany(EducationLevel::class)
                    ->using(EducationLevelUser::class)
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function anounces()
    {
        return $this->hasMany(Anounce::class);
    }

    public function postuls()
    {
        return $this->hasMany(Postul::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
