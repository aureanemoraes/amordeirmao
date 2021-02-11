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
        'is_validated',
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
        return $this->hasMany(Donate::class);
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
    // Functions
    public function getUserType() {
        $id = $this->attributes['id'];
        $isDirector = Director::where('user_id', $id)->first();
        if(isset($isDirector)) {
            $managers_count = Manager::where('director_id', $isDirector->id)->count();
            $managers_link = '<a href="' . route('manager.index', ['director' => $isDirector->id]) . '">' . $managers_count . ' gerentes' . '</a>';
            $believers_count = Responsable::where('responsable_id', $isDirector->id)->count();
            $believers_link = '<a href="' . route('responsable.index', ['responsable' => $isDirector->id]) . '">' . $believers_count . ' fiés' . '</a>';
            return 'Diretor - Responsável por: ' . $managers_link . ' e ' . $believers_link;
        } else {
            $isManager = Manager::where('user_id', $id)->first();
            if(isset($isManager)) {
                $director_link = '<a href="' . route('user.show', $isManager->director->user->id) . '">' . $isManager->director->user->name . '</a>';
                $believers_count = Responsable::where('responsable_id', $isManager->id)->count();
                $believers_link = '<a href="' . route('responsable.index', ['responsable' => $isManager->id]) . '">' . $believers_count . ' fiés' . '</a>';
                return 'Gerente do(a) diretor(a) ' . $director_link . ' - Responsável por: ' . $believers_link;
            } else {
                $responsable = Responsable::where('user_id', $this->id)->first();
                if(isset($responsable)) {
                    $responsable_link = '<a href="' . route('user.show', $responsable->responsable_person->id) . '">' . $responsable->responsable_person->name . '</a>';
                    return 'Padrão - Sob supervisão do(a): ' . $responsable_link;
                } else {
                    return 'Padrão - Sob supervisão do(a): Sem supervisor';
                }

            }
        }
    }
    // Accessors
    public function getUserTypeAttribute() {
        $id = $this->attributes['id'];
        $isDirector = Director::where('user_id', $id)->first();
        if(isset($isDirector)) {
            return 'Diretor';
        } else {
            $isManager = Manager::where('user_id', $id)->first();
            if(isset($isManager)) {
                return 'Gerente';
            } else {
                return 'Padrão';
            }
        }
    }

    public function getFullAddressAttribute($value) {
        if(count($this->addresses) > 0 ) {
            if(count($this->addresses) == 1) {
                foreach($this->addresses as $address) {
                    $address_formatted = $address->zip_code . ' - ' . $address->public_place . ', ' . $address->number . ', ' . $address->neighborhood . ' (' . $address->reference_place . ')';
                }
                return $address_formatted;
            } else {
                $address_formatted = '';
                foreach($this->addresses as $address) {
                    $address_formatted .= $address->zip_code . ' - ' . $address->public_place . ', ' . $address->number . ', ' . $address->neighborhood . ' (' . $address->reference_place . '), ';
                }
                return $address_formatted;
            }
        }
    }

    // Mutators
    public function setNameAttribute($value) {
        $this->attributes['name'] = ucwords($value);
    }

    public function setPasswordAttribute($value) {
        if(!isset($this->password)) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
