<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeographicService;
use App\Http\Resources\EstadoCollection;
use App\Http\Resources\ApiPaisCollection;
use App\Http\Resources\PaisConLenguajeCollection;
use App\Http\Resources\ContinenteCollection;
use Illuminate\Http\Request;

class GeographicController extends Controller
{
    /**
     * Obtener los estados donde se registran más sociedades.
     *
     * @OA\Get(
     *    path="/api/topEstados",
     *    summary="Top Estados",
     *    description="Top Estados",
     *    operationId="getTopEstados",
     *    tags={"estados"},
     *    @OA\Parameter(
     *         name="cantidad",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *           type="int"
     *         )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="OK"
     *    ),
     *    @OA\Response(
     *       response=500,
     *       description="500 internal server error",
     *       @OA\JsonContent(
     *          example="500 internal server error"
     *       )
     *    ),
     * )
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopEstados(Request $request, GeographicService $service)
    {
        return response()->json(new EstadoCollection($service->getTopEstados($request->query('cantidad'))), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Top idiomas.
     *
     * @OA\Get(
     *    path="/api/topIdiomas",
     *    summary="Top idiomas",
     *    description="Top idiomas",
     *    operationId="getTopIdiomas",
     *    tags={"idiomas"},
     *    @OA\Parameter(
     *         name="cantidad",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *           type="int"
     *         )
     *    ),
     *    @OA\Response(
     *       response=200,
     *       description="OK"
     *    ),
     *    @OA\Response(
     *       response=500,
     *       description="500 internal server error",
     *       @OA\JsonContent(
     *          example="500 internal server error"
     *       )
     *    ),
     * )
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopIdiomas(Request $request, GeographicService $service)
    {
        return response()->json(new PaisConLenguajeCollection($service->getTopIdiomas($request->query('cantidad'))), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Obtene el continente hacia donde más se exporta (excluido América).
     *
     * @OA\Get(
     *    path="/api/topContinente",
     *    summary="El continente del planeta (excluido América) hacia donde más se exporta",
     *    description="El continente del planeta (excluido América) hacia donde más se exporta",
     *    operationId="getTopContinente",
     *    tags={"continentes"},
     *    @OA\Response(
     *       response=200,
     *       description="OK"
     *    ),
     *    @OA\Response(
     *       response=500,
     *       description="500 internal server error",
     *       @OA\JsonContent(
     *          example="500 internal server error"
     *       )
     *    ),
     * )
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopContinente(GeographicService $service)
    {
        return response()->json(new ContinenteCollection($service->getTopContinente()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Obtener los continentes hacia los que no se exporta
     *
     * @OA\Get(
     *    path="/api/continentesNoSeExporta",
     *    summary="Continentes hacia los que no se exporta",
     *    description="Continentes hacia los que no se exporta",
     *    operationId="getContinentesHaciaDondeNoSeExporta",
     *    tags={"continentes"},
     *    @OA\Response(
     *       response=200,
     *       description="OK"
     *    ),
     *    @OA\Response(
     *       response=500,
     *       description="500 internal server error",
     *       @OA\JsonContent(
     *          example="500 internal server error"
     *       )
     *    ),
     * )
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContinentesHaciaDondeNoSeExporta(GeographicService $service)
    {
        return response()->json(new ContinenteCollection($service->getContinentesHaciaDondeNoSeExporta()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Obtener los paises hacia los que no se exporta
     *
     * @OA\Get(
     *    path="/api/paisesNoSeExporta",
     *    summary="Paises hacia los que no se exporta",
     *    description="Paises hacia los que no se exporta",
     *    operationId="getPaisesHaciaDondeNoSeExporta",
     *    tags={"paises"},
     *    @OA\Response(
     *       response=200,
     *       description="OK"
     *    ),
     *    @OA\Response(
     *       response=500,
     *       description="500 internal server error",
     *       @OA\JsonContent(
     *          example="500 internal server error"
     *       )
     *    ),
     * )
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaisesHaciaDondeNoSeExporta(GeographicService $service)
    {
        return response()->json(new ApiPaisCollection($service->getPaisesHaciaDondeNoSeExporta()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
