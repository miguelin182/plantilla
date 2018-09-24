<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 14/09/2018
 * Time: 11:35 AM
 */

namespace App\Repositories;


use     App\Helpers\ResponseHelper;
use App\Models\Empresa;
use Core\Log;

class EmpresaRepository
{
    private $Empresa;

    public  function __construct()
    {
        $this->Empresa = new Empresa();
    }

    public function guardar(Empresa $model):ResponseHelper{
        $rh = new ResponseHelper();

        try{
            $this->Empresa->id_empresa = $model->id_empresa;
            $this->Empresa->razon_social = $model->razon_social;
            $this->Empresa->direccion = $model->direccion;
            $this->Empresa->email_empresa = $model->email_empresa;
            $this->Empresa->rfc = $model->rfc;
            $this->Empresa->telefono = $model->telefono;
            $this->Empresa->representante = $model->representante;
            $this->Empresa->email_representante = $model->email_representante;
            $this->Empresa->celular = $model->celular;
            $this->Empresa->giro = $model->giro;
            $this->Empresa->sector = $model->sector;

            if (!empty($model->id_empresa)){
                /*
                 * Al setear este valor a True hacemos que Eloquent lo considere como un registro existente,
                 * por lo tanto hará un update
                 */
                $this->Empresa->exists = true;
            }

            $this->Empresa->save();
            $rh->setResponse(true);

        }catch (\Exception $e){
            Log::error(EmpresaRepository::class, $e->getMessage());
            $rh->setResponse(false);
        }
        return $rh;
    }

}