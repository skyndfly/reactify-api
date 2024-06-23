<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Brand\BrandCollection;
use App\Http\Resources\CarModels\CarModelsCollection;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/brands",
     *     summary="Get all brands",
     *     tags={"Brand"},
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             @OA\Property (
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property (property="id", type="integer", example=1),
     *                     @OA\Property (property="name", type="string", example="Hyundai")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * ),
     */
    public function index(): BrandCollection
    {
        return new BrandCollection(Brand::all());
    }
    /**
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
     *          description="Ok",
     *          @OA\JsonContent(
     *              @OA\Property (
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property (property="id", type="integer", example=1),
     *                      @OA\Property (property="name", type="string", example="Hyundai")
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     *  ),
     */
    public function brandsChildren(int $brandId): CarModelsCollection
    {
        return new CarModelsCollection(Brand::find($brandId)->models);

    }
}
