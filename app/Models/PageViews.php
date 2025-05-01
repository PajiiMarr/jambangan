<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PageViews extends Model
{
    protected $table = 'page_views';
    protected $primaryKey = 'id';
    protected $fillable = ['path', 'year', 'month', 'day', 'views'];
    public $timestamps = true;
}
