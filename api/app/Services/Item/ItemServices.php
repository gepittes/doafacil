<?php

namespace App\Services\Item;

use App\Models\Item;

class ItemServices
{
    public static function get($id)
    {
        try {
            return Item::findOrFail($id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function post($request)
    {
        try {
            return Item::create($request);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function patch($request, $id)
    {
        try {
            return Item::findOrfail($id)->update($request);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function delete($id)
    {
        try {
            return Item::findOrfail($id)->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
