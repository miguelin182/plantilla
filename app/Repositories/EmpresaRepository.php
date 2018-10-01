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
use App\Models\Usuario;
use Core\Log;
use Illuminate\Support\Facades\DB;

class EmpresaRepository
{
    private $Empresa;
    private $Usuario;

    public  function __construct()
    {
        $this->Empresa = new Empresa();
        $this->Usuario = new Usuario();
    }

    public function guardar(Empresa $model, Usuario $model2):ResponseHelper{
        $rh = new ResponseHelper();

        try{
            DB::beginTransaction();
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

            $sEmpresa = $this->Empresa->save();

            $this->Usuario->id = $model2->id;
            $this->Usuario->rol_id = $model2->rol_id;
            $this->Usuario->nombre = $model2->nombre;
            $this->Usuario->email = $model2->email;
            $this->Usuario->id_emp = $this->Empresa->id;

            if(!empty($model2->id)){
                /*
                 * Al setear este valor a True hacemos que Eloquent lo considere como un registro existente,
                 * por lo tanto hará un update
                 */
                $this->Usuario->exists = true;

                if(!empty($model2->password)) {
                    $this->Usuario->password = sha1($model2->password);
                }
            } else {
                $this->Usuario->password = sha1($model2->password);
            }

            $sUsuario = $this->Usuario->save();

            if (!$sEmpresa || !$sUsuario){
                DB::rollBack();
                $rh->setResponse(false);
            } else {
                DB::commit();
                $rh->setResponse(true);
            }
        }catch (\Exception $e){
            Log::error(EmpresaRepository::class, $e->getMessage());
            $rh->setResponse(false);
        }
        return $rh;
    }

}