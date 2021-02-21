<?php

namespace App\Transformers\Users;

use App\Models\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class UserTransformer extends TransformerAbstract {
  /**
   * @param \App\Model\User $model
   * @return array
   */
  public function transform(User $model) {
    return [
      'id' => $model->uuid,
      'name' => $model->name,
      'email' => $model->email,
      'phone' => $model->phone,
      'created_at' => $model->created_at->toIso8601String(),
      'updated_at' => $model->updated_at->toIso8601String(),
    ];
  }
}
