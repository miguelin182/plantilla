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
use Illuminate\Database\Eloquent\Collection;

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
            $this->credit->plazo = $model->plazo;

            if(!empty($model->id_rel)) {
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

    public function actualizarEstado (Credit $model): ResponseHelper{
        $rh = new ResponseHelper();
        try{
            if (!empty($model->estado1)){
                $this->credit->where('id_rel',$model->id_rel)->update(['estado1' => $model->estado1]);
            }
            if (!empty($model->estado2)){
                $this->credit->where('id_rel',$model->id_rel)->update(['estado2' => $model->estado2]);
            }
            if (!empty($model->estado3)){
                $this->credit->where('id_rel',$model->id_rel)->update(['estado3' => $model->estado3]);
            }
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

    public function listar($id_cli, $id_emp): Collection{
        $creditos = [];
        try{
            $creditos = $this->credit->where([
                ['id_cli','=',$id_cli],
                ['id_emp','=',$id_emp]
            ])->get();
        }catch (\Exception $e){
            Log::error(UsuarioRepository::class, $e->getMessage());
        }
        return $creditos;
    }

    public function listarsinemp($id_cli): Collection{
        $creditos = [];
        try{
            $creditos = $this->credit->select('monto','activo','plazo','estado1','estado2','estado3','created_at')->where('id_cli','=',$id_cli)->get();
        }catch (\Exception $e){
            Log::error(UsuarioRepository::class, $e->getMessage());
        }
        return $creditos;
    }
}