<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgUnit extends Model
{
    protected $table = 'org_units';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'position', 'parent_id'];
}
