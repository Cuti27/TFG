<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    use HasFactory;

    protected $table = 'timer';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timeStart',
        'duration',
        'postIrrigation',
        'programId',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getEndTimeAttribute()
    {
        return date('H:i:s', strtotime($this->timeStart) + strtotime($this->duration)
            + strtotime($this->postIrrigation) - strtotime('00:00:00'));
    }
}
