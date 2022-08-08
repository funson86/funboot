<?php

namespace api\controllers;

use common\models\school\Student;
use common\models\User;
use yii\data\ActiveDataProvider;

/**
 * Class UserController
 * @package api\controllers
 * @author funson86 <funson86@gmail.com>
 */
class StudentController extends BaseController
{
    /**
     * @var string the model class name. This property must be set.
     */
    public $modelClass = Student::class;

    public $optionalAuth = ['index', 'view', 'create', 'update', 'delete'];

    /**
     * @OA\Get(
     *     path="/api/students",
     *     tags={"Student"},
     *     summary="List records",
     *     description="list ?page=2 pagination ?name='funson&created_at=>1648607050 search",
     *     @OA\Response(response="200", description="Success")
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/students/{id}",
     *     tags={"Student"},
     *     summary="View one record",
     *     description="View one record",
     *     @OA\Parameter(name="id", required=true, @OA\Schema(type="string"), in="path", description="id"),
     *     @OA\Response(response="200", description="Success")
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/students",
     *     tags={"Student"},
     *     summary="Create a new record",
     *     description="Create a new record",
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name", type="string", description="Name"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/students/{id}",
     *     tags={"Student"},
     *     summary="Update a record",
     *     description="Update a record",
     *     @OA\Parameter(name="id", required=true, @OA\Schema(type="string"), in="path", description="id"),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(property="name", type="string", description="Name"),
     *           )
     *       )
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
     */

    /**
     * @OA\Delete(
     *     path="/api/students/{id}",
     *     tags={"Student"},
     *     summary="Delete a record",
     *     description="Delete a record",
     *     @OA\Parameter(name="id", required=true, @OA\Schema(type="string"), in="path", description="id"),
     *     @OA\Response(response="200", description="Success")
     * )
     */
}
