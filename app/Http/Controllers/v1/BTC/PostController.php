<?php

namespace App\Http\Controllers\v1\BTC;

use App\Http\Controllers\Controller;
use App\Services\BTCService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected ?BTCService $service = null;

    public function __construct()
    {
        $this->service = new BTCService();
    }
    /**
     * @param Request $request
     * @return Request
     */
    public function __invoke(Request $request)
    {
        $method = $request->get('method');
        return $this->service->$method($request);
    }
}
