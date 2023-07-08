<?php

namespace App\Http\Controllers\v1\BTC;

use App\Http\Controllers\Controller;
use App\Services\BTCService;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    protected array $methods = ['convert'];
}
