<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $primaryKey = 'id_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'is_active',
        'is_verified',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active'   => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Relasi ke kelas yang diikuti user (untuk siswa)
     */
    public function enrollments()
    {
        return $this->hasMany(\App\Models\ClassEnrollment::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke kelas yang dibuat user (untuk guru)
     */
    public function createdClasses()
    {
        return $this->hasMany(\App\Models\Classes::class, 'created_by', 'id_user');
    }
}
