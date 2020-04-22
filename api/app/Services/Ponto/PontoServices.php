<?php

namespace App\Services\Ponto;

use App\Models\Endereco;
use App\Models\PontoDeDoacao;

class PontoServices
{
    public static function get($id = null, $instituicao_id = null)
    {
        $data = PontoDeDoacao::get();

        try {
            if (!empty(trim($id))) {
                $data = PontoDeDoacao::get($id);
            }

            if (!empty(trim($instituicao_id))) {
                $data = PontoDeDoacao::get(null, $instituicao_id);
            }

            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function post($data)
    {
        try {
            $endereco = Endereco::store($data['endereco']);
            unset($data['endereco']);
            $data['endereco_id'] = $endereco->id;

            $ponto = PontoDeDoacao::create($data);

            return self::get($ponto->id);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function patch($id, $data)
    {
        try {
            $ponto = PontoDeDoacao::findOrFail($id);
            Endereco::patch($ponto->endereco_id, $data['endereco']);
            unset($data['endereco']);

            PontoDeDoacao::findOrFail($id)->update($data);
            $ponto = PontoDeDoacao::find($id);

            return $ponto;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function delete($id)
    {
        return PontoDeDoacao::findOrFail($id)->delete();
    }

    public static function setImage($id, $image)
    {
        $ponto = PontoDeDoacao::find($id);
        $ponto->image =  $image;
        $ponto->update();

        return $ponto;
    }
}
