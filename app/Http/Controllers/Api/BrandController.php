<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\CarModels\CarModelsCollection;
use App\Models\Brand;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/v1/brands",
 *     summary="Get all brands",
 *     tags={"Brand"},
 *     @OA\RequestBody(
 *
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Ok"
 *     ),
 * ),
 * @OA\Get(
 *      path="/api/v1/brands/{id}/models",
 *      summary="Get all models by brand id",
 *      tags={"Brand"},
 *      @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the brand",
 *          example=1,
 *          @OA\Schema (
 *              type="integer",
 *              format="int64"
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Ok"
 *      ),
 *  ),
 */
class BrandController extends Controller
{
    public function index(): BrandCollection
    {
        return new BrandCollection(Brand::all());
    }

    public function getChildren(int $brandId)
    {
        return new CarModelsCollection(Brand::find($brandId)->models);

    }
}
