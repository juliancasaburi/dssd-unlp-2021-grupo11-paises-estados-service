<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pais;

class Continente extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Obtener los paises.
     */
    public function pais()
    {
        return $this->hasMany(Pais::class);
    }

    /**
     * Obtener las sociedades anonimas.
     */
    public function sociedadesAnonimas()
    {
        return $this->hasManyDeepFromRelations($this->pais(), (new Pais)->sociedadesAnonimas());
    }
}
