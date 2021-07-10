<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditpositionTbl extends Model
{
  use HasFactory;
  const CREATED_AT = 'create_time';
  const UPDATED_AT = 'edit_time';

  protected $primaryKey = "unid";
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;
  public $table = 'tbl_auditposition';
  protected $fillable = [
         'unid',
         'position_no',
         'position_name',
         'position_name_eng',
         'auditor_period',
         'period_qty',
          'period_type',
         'create_by',
         'create_time',
         'edit_by',
         'edit_time',
         'status',
     ];

}
