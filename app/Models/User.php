<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'quality_id',
        'is_validated'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // RELATIONSHIPS
    public function quality() {
        return $this->belongsTo(Quality::class);
    }

    public function donates() {
        return $this->hasMany(Donate::class, 'user_id', 'id');
    }

    public function directors() {
        return $this->hasMany(Director::class, 'user_id', 'id');
    }

    public function managers() {
        return $this->hasMany(Manager::class, 'user_id', 'id');
    }

    public function phones() {
        return $this->hasMany(Phone::class, 'user_id', 'id');
    }

    public function addresses() {
        return $this->belongsToMany(Address::class, 'users_addresses', 'user_id', 'address_id');
    }
    /*
    public function fies() {
        return $this->hasMany(Responsable::class, 'responsable_id', 'id');
    }
    */

    // Accessors
}
