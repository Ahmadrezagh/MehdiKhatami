<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;
    protected $fillable = [
        'left',
        'right'
    ];
    protected $with = ['left_flag','right_flag'];
    public function left_flag()
    {
        return $this->belongsTo(Flag::class,'left');
    }

    public function right_flag()
    {
        return $this->belongsTo(Flag::class,'right');
    }

    public function title()
    {
        return Flag::find($this->left)->name."/".Flag::find($this->right)->name;
    }
}
