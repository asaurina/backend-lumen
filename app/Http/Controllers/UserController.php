<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Transformers\Users\UserTransformer;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserController extends Controller {
  /**
   * @var \App\Models\User
   */
  protected $model;

  /**
   * Create a new controller instance.
   *
   * @var \App\Model\User $model
   * @return void
   */
  public function __construct(User $model) {
    $this->model = $model;
  }

  /**
   * Returns all users
   *
   * @return void
   */
  public function index() {
    return UserResource::collection(User::all());
  }

  /**
   * Returns the user to the API
   *
   * @param  $uuid
   * @return UserResource
   */
  public function show($uuid) {
    $user = $this->model->byUuid($uuid)->firstOrFail();

    return new UserResource($user, new UserTransformer());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return UserResource
   */
  public function store(Request $request) {
    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|email|unique:users,email',
    ]);

    $user = $this->model->create($request->all());

    return response()->json([
      'message' => ['Se agregó con éxito el nuevo usuario.'],
      'data' => new UserResource($user),
    ]);
  }

  /**
   * @param \Illuminate\Http\Request  $request
   * @param $uuid
   * @return UserResource
   */
  public function update(Request $request, $uuid) {
    $user = $this->model->byUuid($uuid)->firstOrFail();

    $rules = [
      'name' => 'required',
      'email' => 'required|email|unique:users,email,' . $user->id,
    ];
    if ($request->method() == 'PATCH') {
      $rules = [
        'name' => 'sometimes|required',
        'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
      ];
    }
    $this->validate($request, $rules);

    $user->update($request->except('_token'));

    return response()->json([
      'message' => ['El usuario se ha actualizado con éxito.'],
      'data' => new UserResource($user->fresh(), new UserTransformer()),
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \Illuminate\Http\Request  $request
   * @param $uuid
   * @return mixed
   */
  public function destroy(Request $request, $uuid) {
    $user = $this->model->byUuid($uuid)->firstOrFail();

    if ($user->trashed()) {
      $user->forceDelete();
    } else {
      $user->delete();
    }

    return response()->json(['message' => ['Se eleminó el usuario con éxito']], 200);
  }

  /**
   * Restore the specified resource from storage.
   *
   * @param $uuid
   * @return mixed
   */
  public function restore($uuid) {
    $user = $this->model->withTrashed()->byUuid($uuid)->firstOrFail();

    if ($user->trashed()) {
      $user->restore();
    }

    return new UserResource($user, new UserTransformer());
  }
}
