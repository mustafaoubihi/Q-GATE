<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem',
        'zone',
        'post',
        'nbProblems',
        'isChecked',
        'valideImgUrl',
        'notValideImgUrl',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
