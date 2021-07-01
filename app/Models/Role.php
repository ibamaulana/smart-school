<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'role';

    protected $fillable = [
        'name',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
