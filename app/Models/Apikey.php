<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apikey extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    public function id64()
    {
        return base64_encode($this->id);
    }

    public function key()
    {
        return base64_encode($this->user()->username . ':' . $this->key);
    }
}
