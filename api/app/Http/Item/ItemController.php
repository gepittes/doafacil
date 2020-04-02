<?php

namespace App\Http\Controllers\Item;

use App\Models\Item;
use App\Services\Item\ItemServices;
use Laravel\Lumen\Routing\Controller;
use Psr\Http\Message\ServerRequestInterface;

class ItemController extends Controller
{
    public function get($id = null)
    {
        if (!empty(trim($id))) return response()->json(ItemServices::get($id));

        return response()->json(Item::all(), 200);
    }

    public function post(ServerRequestInterface $request)
    {
        try {
            $request = $request->getParsedBody();
            return response()->json(ItemServices::post($request));
        } catch (\Exception $e) {
            return response()->json($e, 204);
        }
    }

    public function patch(ServerRequestInterface $request, $id)
    {
        try {
            $request = $request->getParsedBody();
            return response()->json(ItemServices::patch($request, $id), 200);
        } catch (\Exception $e) {
            return response()->json($e, 204);
        }
    }

    public function delete($id)
    {
        try {
            return response()->json(ItemServices::delete($id), 200);
        } catch (\Exception $e) {
            return response()->json($e, 204);
        }
    }

    public function getItensByInsti($id)
    {
        return response()->json(Item::getItensByInsti($id), 200);
    }
}
