<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apps extends Model
{
  protected $table        = 'tbl_apps_link';
  protected $primaryKey   = 'id';
  public $timestamps      = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'id', 'nama_apps', 'link_apps', 'deskripsi', 'corp_apps', 'status',
    'create_date', 'create_by', 'update_date', 'update_by'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    //'create_date', 'create_by', 'update_date', 'update_by'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [];
}
