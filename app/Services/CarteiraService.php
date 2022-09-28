<?php

namespace App\Services;

use App\Models\Carteira;
use App\Models\Usuario;

class CarteiraService
{

    public function getAllCarteiras()
    {
        return Carteira::all();
    }

    public function searchCarteirasByName(string $name)
    {
        return Carteira
            ::query()
            ->where('nome', 'like', "%$name%")
            ->get();
    }

    public function createCarteira(array $data)
    {
        $carteira = new Carteira();
        $this->saveCarteita($carteira, $data);
    }

    public function getCarteiraById(int $id)
    {
        return Carteira::find($id);
    }

    public function editCarteira(array $data, int $id)
    {
        $carteira = $this->getCarteiraById($id);
        $this->saveCarteita($carteira, $data);
    }

    public function deleteCarteira(int $id)
    {
        $carteira = $this->getCarteiraById($id);
        $carteira->delete();
    }

    private function saveCarteita(Carteira $carteira, array $data)
    {
        $carteira->nome = $data['nome'];
        $carteira->responsavel_id = $data['responsavel_id'];
        $carteira->setor = $data['setor'];
        $carteira->save();
    }

    public function getCarteiraByType(string $setor)
    {
        return Carteira
            ::query()
            ->where('setor', $setor)
            ->get();
    }
    public function getCarteiraLike(string $setor)
    {
        return Carteira
            ::query()
            ->where('setor','like', "%{$setor}%")
            ->get();
    }
}
