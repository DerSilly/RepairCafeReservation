<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];
    const ADMIN = 'Admin';
    const STAFF = 'Staff';
    const GUEST = 'Guest';
    public function users()
    {
         return $this->belongsToMany(User::class, 'role_user_assignments');
    }
}
