<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        if(!$this->hasPermission('setting.email')){
            return  response()->view('errors.401', [], 401);
        }

        return view('setting.application');
    }
}
