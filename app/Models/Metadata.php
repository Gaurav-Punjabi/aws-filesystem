<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public $timestamps = true;

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Metadata::class, "parent_id");
    }

    public function children() {
        return $this->hasMany(Metadata::class, "parent_id");
    }
}
