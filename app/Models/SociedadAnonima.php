<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SociedadAnonima extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sociedades_anonimas';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'bonita_case_id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'fecha_creacion',
        'domicilio_legal',
        'domicilio_real',
        'email_apoderado',
        'numero_expediente',
        'numero_hash',
        'url_codigo_QR',
        'estado_evaluacion',
        'bonita_case_id',
        'apoderado_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    /**
     * Obtener los estados a los que exporta.
     */
    public function estados()
    {
        return $this->belongsToMany(Estado::class, 'sociedades_anonimas_estados')->withTimestamps();
    }
}
