<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 10/09/2018
 * Time: 02:42 PM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Credit;
use Core\Log;

class CreditRepository
{
    private $credit;

    public function __construct()
    {
        $this->credit = new Credit();
    }

    public function guardar(Credit $model): ResponseHelper {
        $rh = new ResponseHelper();
        try{
            $this->credit->id_cli = $model->id_cli;
            $this->credit->id_emp = $model->id_emp;
            $this->credit->monto = $model->monto;
            $this->credit->activo = $model->activo;
            $this->credit->plazo = $model->plazo;

            if(!empty($model->id_cliente)) {
                $this->credit->exists = true;
            }

            $this->credit->save();
            $rh->setResponse(true);
        } catch (\Exception $e){
            Log::error(CreditRepository::class, $e->getMessage());
            $rh->setResponse(false);
        }
        return $rh;
    }

    public function obtener($id) : Credit {
        $credit = new Credit();

        try {
            $credit = $this->credit->find($id);
        } catch (\Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $credit;
    }
}