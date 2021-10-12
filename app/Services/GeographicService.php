<?php

namespace App\Services;

use App\Models\Continente;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\SociedadAnonima;
use GraphQL\Client;
use GraphQL\Query;
use GraphQL\RawObject;
use GraphQL\Variable;

class GeographicService
{

    public function getTopEstados()
    {
        $estados = Estado::withCount('sociedadesAnonimas')
            ->orderBy('sociedades_anonimas_count', 'desc')
            ->take(2)
            ->get();
        return $estados;
    }

    public function getTopIdiomas()
    {
        $paises = Pais::withCount('sociedadesAnonimas')
            ->orderBy('sociedades_anonimas_count', 'desc')
            ->take(2)
            ->get();

            $client = new Client(
                'https://countries.trevorblades.com/',
            );
            
            $paises->map(function ($pais) use ($client) {
                $gql = <<<QUERY
                query {
                    countries (filter: {
                        code: { eq: "$pais->code"}
                    }) {
                    languages {
                    name
                    }
                    code
                    name
                    continent {
                    name
                    }
                }
                }
                QUERY;

                $results = $client->runRawQuery($gql);
                $languages = $results->getData()->countries[0]->languages;

                $pais['languages'] = $languages;
                return $pais;
            });

        return $paises;
    }
}
