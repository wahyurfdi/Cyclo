<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashTransactionItem extends Model
{
    use HasFactory;

    protected $table = 'trash_transaction_item';
    public $timestamps = true;
}
