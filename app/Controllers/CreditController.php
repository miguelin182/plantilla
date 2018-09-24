<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 10/09/2018
 * Time: 09:19 AM
 */

namespace App\Controllers;


use App\Helpers\ResponseHelper;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use App\Validations\ClientValidation;
use Core\Auth;
use Core\Controller;

class CreditController extends Controller
{
    private $clienteRepo;
    public function __construct()
    {
        parent::__construct();
        $this->clienteRepo = new ClienteRepository();
    }

    public  function  getIndex(){
        return $this->render('credit/Index.twig',[
           'title' => 'Consultas'
        ]);
    }
    public function getClientef (){
        return $this->render('credit/clientform.twig', [
            'title' => 'Cliente Nuevo'
        ]);
    }

    public function getNewclient (){
        return $this->render('credit/newclient.twig', [
            'title' => 'Cliente nuevo'
        ]);
    }

    public function getSearchclient (){
        return $this->render('credit/searchclient.twig', [
            'title' => 'Buscar cliente'
        ]);
    }

    /**
     * Guarda un cliente nuevo a la base de datos
     */
    public function postGcliente(){
        $model = new Cliente();

        if (isset($_POST['id_cliente'])){
            $model->id_cliente = $_POST['id_cliente'];
        }
        $model->nombre = $_POST['nombre'];
        $model->rfc = $_POST['rfc'];
        $model->telefono = $_POST['telefono'];
        $model->celular = $_POST['celular'];
        $model->persona = $_POST['persona'];
        $model->email = $_POST['email'];
        $rh = $this->clienteRepo->guardar($model);


        print_r(
            json_encode($rh)
        );

    }
    public function postBuscarc(){
        $rh = new  ResponseHelper();
        $busqueda = $_POST['busqueda'];

        print_r(
            json_encode($this->clienteRepo->listarN($busqueda))
        );
    }
    public function postUsuario(){
        print_r(
            json_encode(Auth::getCurrentUser())
        );
    }
}