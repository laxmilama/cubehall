<?php

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPage extends Model
{
    use HasFactory;
    use  HasRolesAndPermissions;
    protected $guard='admin';
}
