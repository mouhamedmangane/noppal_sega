<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPrix extends Model
{
    use HasFactory;

    protected $table="contact_prix";

    /**
     * Get the user that owns the Vente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function contact()
    {
        return $this->belongsTo('App\Models\Contact','contact_id','id');
    }

    public function bois(){
        return $this->belongsTo('App\Models\Bois','bois_id','id');
    }



}
