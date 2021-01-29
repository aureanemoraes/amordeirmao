<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'managers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['user_id', 'director_id'];
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
    */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function director() {
        return $this->belongsTo(Director::class);
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
    public function getBelieversProfilesUrls() {
        $data = Responsable::where('responsable_id', $this->user_id)->get();
        //dd($believers);
        if($data->count() > 0) {
            $believers = '<ul>';
            foreach($data as $believer) {
                $believers .= '<li><a href="' . route('user.show', $believer->user_id). '" target="_blank">' . $believer->user->name . '</a></li>';
            }
            $believers .= '</ul>';
            return $believers;
        }
    }

    public function getUserProfileUrl() {
        return '<a href="' . route('user.show', $this->user->id). '" target="_blank">' . $this->user->name . '</a>';
    }

    public function getDirectorProfileUrl() {
        //dd($this->director->user);
        return '<a href="' . route('user.show', $this->director->user->id). '" target="_blank">' . $this->director->user->name . '</a>';
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
