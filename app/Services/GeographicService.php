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

    public function getTopContinente() // excluido América
    {
        $continentes = Continente::where([
            ['name', '!=', 'North America'],
            ['name', '!=', 'South America'],
        ])->withCount('sociedadesAnonimas')
            ->orderBy('sociedades_anonimas_count', 'desc')
            ->take(1)
            ->get();

        return $continentes;
    }

    public function getContinentesHaciaDondeNoSeExporta()
    {
        $continentes = Continente::all();
        /* Verificar si se exporta hacia todos los continentes, para no realizar request a la API
        https://countries.trevorblades.com/ usa el modelo de 7 continentes
        https://en.wikipedia.org/wiki/Continent#/media/File:Continental_models-Australia.gif
        */
        if ($continentes->count() == 7)
            return [];
        else {
            $client = new Client(
                'https://countries.trevorblades.com/',
            );
            $gql = <<<QUERY
                    query {
                        continents {
                            name
                        }
                    }
                    QUERY;

            $apiContinentes = collect($client->runRawQuery($gql)->getData()->continents);

            return $apiContinentes->whereNotIn('name', $continentes->pluck('name'));
        }
    }

    public function getPaisesHaciaDondeNoSeExporta()
    {
        return [];
    }
}
