<?php

namespace App\Services;

use App\Models\Continente;
use App\Models\Pais;
use App\Models\Estado;
use GraphQL\Client;

class GeographicService
{
    private function getCountriesAPIClient()
    {
        return new Client(
            'https://countries.trevorblades.com/',
        );
    }

    public function getTopEstados($cantidad = 2)
    {
        $estados = Estado::withCount('sociedadesAnonimas')
            ->orderBy('sociedades_anonimas_count', 'desc')
            ->take($cantidad)
            ->get();

        return $estados->where('sociedades_anonimas_count', '>', 0);
    }

    public function getTopIdiomas($cantidad = 2)
    {
        $paises = Pais::withCount('sociedadesAnonimas')
            ->orderBy('sociedades_anonimas_count', 'desc')
            ->take($cantidad)
            ->get();

        $paises = $paises->where('sociedades_anonimas_count', '>', 0);

        $client = $this->getCountriesAPIClient();
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

            $pais['languages'] = $client->runRawQuery($gql)->getData()->countries[0]->languages;
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

        return $continentes->where('sociedades_anonimas_count', '>', 0);
    }

    public function getContinentesHaciaDondeNoSeExporta()
    {
        $continentes = Continente::withCount('sociedadesAnonimas')
                                    ->get()
                                    ->where('sociedades_anonimas_count', '>', 0);
        /* Verificar si se exporta hacia todos los continentes, para no realizar request a la API
        https://countries.trevorblades.com/ usa el modelo de 7 continentes
        https://en.wikipedia.org/wiki/Continent#/media/File:Continental_models-Australia.gif
        */
        if ($continentes->count() == 7)
            return [];
        else {
            $client = $this->getCountriesAPIClient();
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
        $paises = Pais::withCount('sociedadesAnonimas')
                        ->get()
                        ->where('sociedades_anonimas_count', '>', 0);

        $client = $this->getCountriesAPIClient();
        $gql = <<<QUERY
                    query {
                        countries {
                            name
                        }
                    }
                    QUERY;

        $apiPaises = collect($client->runRawQuery($gql)->getData()->countries);

        return $apiPaises->whereNotIn('name', $paises->pluck('name'))->values();
    }
}
