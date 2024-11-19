<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'from_date' ,
        'to_date' ,
        'state_id',
        'pm25',
        'pm10',
        'No',
        'No2',
        'NOx',
        'NH3',
        'SO2',
        'CO',
        'AT',
        'Temp',
    ];

    public function state(){
        return $this->belongsTo(State::class,"state_id");  // Assuming State model has a foreign key 'id' for 'state_id' column. If the column name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state_id' column. If the model name is different, adjust the model name and foreign key accordingly.  // Assuming State model is named 'State' and has a foreign key 'id' for 'state
    }
}
