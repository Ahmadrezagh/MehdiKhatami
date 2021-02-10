<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signal extends Model
{
    use HasFactory;

    protected $with = ['exchange','signal_type','command','result'];

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }

    public function signal_type()
    {
        return $this->belongsTo(SignalType::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function command()
    {
        return $this->belongsTo(Command::class);
    }


}
