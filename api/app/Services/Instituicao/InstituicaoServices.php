<?php

namespace App\Services\Instituicao;

use App\Models\Endereco;
use App\Models\Instituicao;

class InstituicaoServices
{
    public static function get($id = null, $name_fk = null)
    {
        $data = Instituicao::all();

        try {
            if (!empty(trim($id))) {
                $data = Instituicao::where('id', '=', $id)->get();
            }

            if (!empty(trim($name_fk))) {
                $data = Instituicao::where($name_fk, '=', $id)->get();
            }

            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function store(array $data = [])
    {
        try {
            $endereco = Endereco::store($data['endereco']);
            unset($data['endereco']);
            $data['endereco_id'] = $endereco->id;

            return Instituicao::create($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public static function update($id, array $data = [])
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
