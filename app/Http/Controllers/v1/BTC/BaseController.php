<?php

namespace App\Http\Controllers\v1\BTC;

use App\Http\Controllers\Controller;
use App\Services\BTCService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected array $methods =  [];
    protected ?BTCService $service = null;

    /**
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        $method = $request->get('method');
        if (!in_array($method, $this->methods)) {
            throw new Exception('Invalid method');
        }
        $this->service = new BTCService();
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function __invoke(Request $request)
    {
        $method = $request->get('method');
        return response([
            'status' => 'success',
            'code' => 200,
            'data' => $this->service->$method($request)
        ], 200);
    }
}
