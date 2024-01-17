<?php 
// app/Models/Site.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'view_site_kategorisasi_load';
    protected $primaryKey = 'site_id';
    protected $fillable = ['site_id', 'category', 'kabupaten','kategorisasi_load'];
}
