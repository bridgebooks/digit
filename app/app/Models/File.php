<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class File extends Model
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

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function creator()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function folder()
    {
      return $this->belongsTo('App\Models\FileFolder', 'folder_id');
    }
}
