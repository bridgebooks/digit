<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class FileFolder extends Model
{
    use SoftDeletes, Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $tables = "file_folders";

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function parent()
    {
      return $this->hasOne('App\Models\FileFolder', 'parent_id');
    }
}
