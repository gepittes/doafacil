<?php

namespace App\Services\Instituicao;

use App\Models\Endereco;
use App\Models\Instituicao;

class InstituicaoServices
{
    public static function get($id = null, $user_id = null)
    {
        $data = Instituicao::get();

        try {
            if (!empty(trim($id))) {
                $data = Instituicao::get($id);
            }

            if (!empty(trim($user_id))) {
                $data = Instituicao::get(null, $user_id);
            }

            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function post(array $data = [])
    {
        try {
            $endereco = Endereco::store($data['endereco']);
            unset($data['endereco']);
            $data['endereco_id'] = $endereco->id;

            $instituicao = Instituicao::create($data);

            return self::get($instituicao->id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function patch($id, array $data = [])
    {
        try {
            $insituicao = Instituicao::findOrFail($id);
            Endereco::patch($insituicao->endereco_id, $data['endereco']);
            unset($data['endereco']);

            Instituicao::findOrFail($id)->update($data);
            $insituicao = Instituicao::find($id);

            return $insituicao;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function delete($id)
    {
        try {
            return Instituicao::findOrFail($id)->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function setImage($id, $image)
    {
        $instituicao = Instituicao::find($id);
        $instituicao->image = $image;
        $instituicao->update();

        return $instituicao;
    }
}
