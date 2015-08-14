<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Sentinel;
use Config;
use App;
use Setting;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $user;

    protected $setting;

    public function __construct()
    {
        $this->user = Sentinel::getUser();
    }


    // public $forbiddenView = response()->view('errors.401', [], 401);

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    public function isSuperUser()
    {
        return $this->user->hasAccess('superuser');
    }

    public function hasPermission($permissions)
    {
        if ($this->isSuperUser())
            return true;

        return $this->user->hasAnyAccess($permissions);

    }
}
