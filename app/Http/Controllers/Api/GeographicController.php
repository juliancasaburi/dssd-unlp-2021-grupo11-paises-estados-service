<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeographicService;
use App\Http\Resources\EstadoCollection;
use App\Http\Resources\PaisCollection;

class GeographicController extends Controller
{
    /**
     * Obtener los estados donde se registran más sociedades.
     *
     * @OA\Get(
     *    path="/api/topEstados",
     *    summary="Estados",
     *    description="Estados",
     *    operationId="getTopEstados",
     *    tags={"estados"},
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
    public function getTopEstados(GeographicService $service)
    {
        return response()->json(new EstadoCollection($service->getTopEstados()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Obtener los estados donde se registran más sociedades.
     *
     * @OA\Get(
     *    path="/api/topIdiomas",
     *    summary="Idiomas",
     *    description="Idiomas",
     *    operationId="getTopIdiomas",
     *    tags={"idiomas"},
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
    public function getTopIdiomas(GeographicService $service)
    {
        return response()->json(new PaisCollection($service->getTopIdiomas()), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
