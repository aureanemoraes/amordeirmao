<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'responsables';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['responsable_id', 'user_id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    public function director() {
        return $this->belongsTo(Director::class);
    }

    public function manager() {
        return $this->belongsTo(Manager::class);
    }
    */


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function responsable_person() {
        return $this->belongsTo(User::class, 'responsable_id', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getUserProfileUrl() {
        return '<a href="' . route('user.show', $this->user->id). '" target="_blank">' . $this->user->name . '</a>';
    }

    public function getResponsablePersonProfileUrl() {
        return '<a href="' . route('user.show', $this->responsable_person->id). '" target="_blank">' . $this->responsable_person->name . '</a>';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
