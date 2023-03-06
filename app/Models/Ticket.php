<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'bus_id',
        'path_id',
        'seat',
        'price',
    ];
    
     /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }
}
