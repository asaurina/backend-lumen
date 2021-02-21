<?php

namespace App\Models;

use App\Support\UuidScopeTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract {
  use Authenticatable, UuidScopeTrait, Authorizable, SoftDeletes, HasFactory;

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
    'deleted_at',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'uuid',
    'name',
    'email',
    'phone',
  ];

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = ['remember_token'];

  /**
   * @param array $attributes
   * @return \Illuminate\Database\Eloquent\Model
   */
  public static function create(array $attributes = []) {
    $model = static::query()->create($attributes);

    return $model;
  }
}
