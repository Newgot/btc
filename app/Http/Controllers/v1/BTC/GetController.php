<?php

namespace App\Http\Controllers\v1\BTC;

use App\Http\Controllers\Controller;
use App\Services\BTCService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetController extends BaseController
{
    protected array $methods = ['rates'];
}

