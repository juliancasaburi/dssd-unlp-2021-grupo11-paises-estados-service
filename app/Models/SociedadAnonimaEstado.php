<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Estado;
use App\Models\SociedadAnonima;

class SociedadAnonimaEstado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sociedades_anonimas_estados';

    /**
     * 
     */
    public function estado()
    {
        return $this->hasOne(Estado::class);
    }

    /**
     * 
     */
    public function sociedadAnonima()
    {
        return $this->hasOne(SociedadAnonima::class);
    }
}
