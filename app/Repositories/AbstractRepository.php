<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository 
{

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function selectAtributosRegistrosRelacionados($atributos) {
        $this->model = $this->model->with($atributos);
    }

    public function filtro($filtros) {
        foreach(explode(',', $filtros) as $key => $filtro) {
            $condicoes = explode(':', $filtro);
            $this->model = $this->model->where($condicoes[0], $condicoes[1], $condicoes[2]);
        }
    }

    public function selectAtributos($atributos) {
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getResultado() {
        return $this->model->get();
    }
}