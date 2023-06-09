<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashTransaction extends Model
{
    use HasFactory;

    protected $table = 'trash_transaction';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = true;
}
