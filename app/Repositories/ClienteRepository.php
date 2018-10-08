<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 17/09/2018
 * Time: 08:39 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Cliente;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepository
{
    private $cliente;
    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function guardar(Cliente $model): ResponseHelper {
        $rh = new ResponseHelper();
        try{
            $this->cliente->id_cliente = $model->id_cliente;
            $this->cliente->nombre = $model->nombre;
            $this->cliente->rfc = $model->rfc;
            $this->cliente->celular = $model->celular;
            $this->cliente->telefono = $model->telefono;
            $this->cliente->email = $model->email;
            $this->cliente->persona = $model->persona;

            if(!empty($model->id_cliente)) {
                $this->cliente->exists = true;
            }

            $this->cliente->save();
            $rh->setResponse(true,'',$this->cliente->id);
        } catch (\Exception $e){
            Log::error(ClienteRepository::class, $e->getMessage());
            $rh->setResponse(false);
        }
        return $rh;
    }

    public function listarN(string $nombre): Collection {
        $lista = [];
        try{
            $lista = $this->cliente->where('nombre','like',$nombre.'%')->get();
        }catch (\Exception $e){
            Log::error(ClienteRepository::class,$e->getMessage());
        }
        return $lista;
    }

    public function listarE(string $nombre, $id): Collection {
        $lista = [];
        try{
            $lista = $this->cliente->leftJoin('bitacora','clientes.id_cliente','=','bitacora.id_cli')->where([
                ['clientes.nombre','like',$nombre.'%'],
                ['bitacora.id_emp','=',$id],
                ['bitacora.accion','=',1]
            ])->get();
        }catch (\Exception $e) {
            Log::error(ClienteRepository::class, $e->getMessage());
        }
        return $lista;
    }

    public function buscarRfc($rfc): Collection {
        $lista = [];
        try{
            $lista = $this->cliente->where('rfc','=',$rfc)->get();
        }catch (\Exception $e){
            Log::error(ClienteRepository::class,$e->getMessage());
        }
        return $lista;
    }

    public function obtener($id) : Collection {
        $cliente = [];

        try {
            $cliente = $this->cliente->where('id_cliente','=',$id)->get();
        } catch (\Exception $e) {
            Log::error(ClienteRepository::class, $e->getMessage());
        }

        return $cliente;
    }
}