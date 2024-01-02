<?php

namespace App\Http\Controllers;

use App\Models\Change;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function save_change($model_id, $model, $action, $data)
    {
        Change::create([
            "env"      => env("APP_ENV"),
            "model_id" => $model_id,
            "model"    => $model,
            "action"   => $action,
            "data"     => $data ? json_encode($data) : null,
        ]);
    }

}
