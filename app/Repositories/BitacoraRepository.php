<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 28/09/2018
 * Time: 10:04 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Bitacora;
use Core\Log;

class BitacoraRepository
{
    private $bitacora;
    public function __construct()
    {
        $this->bitacora = new Bitacora();
    }

    public function Guardar(Bitacora $model): ResponseHelper{
        $rh = new ResponseHelper();
        try{
            $this->bitacora->id_emp = $model->id_emp;
            $this->bitacora->id_cli = $model->id_cli;
            $this->bitacora->accion = $model->accion;

            if(!empty($model->id_bit)) {
                $this->bitacora->exists = true;
            }

            $this->bitacora->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(BitacoraRepository::class, $e->getMessage());
        }
        return $rh;
    }
}