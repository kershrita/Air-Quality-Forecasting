<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function cities(){
        return $this->hasMany(City::class);  // Assuming State model has a foreign key 'id' for 'state_id' column. If the column name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state
    }
}
