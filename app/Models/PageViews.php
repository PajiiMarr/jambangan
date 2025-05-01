<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PageViews extends Model
{
    protected $table = 'page_views';
    protected $primaryKey = 'id';
    protected $fillable = ['year', 'month', 'views'];
    public $timestamps = true;
}
