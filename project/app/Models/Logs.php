<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
  use HasFactory;

  protected $table        = 'table_logs';
  protected $primaryKey   = 'log_id';
  public $timestamps      = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'log_id', 'log_user_id', 'log_url', 'log_type', 'log_time', 'log_data'
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
