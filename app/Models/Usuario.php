<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{
    protected $table = 'usuarios';
    protected $hidden = ['password'];

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol');
    }
}