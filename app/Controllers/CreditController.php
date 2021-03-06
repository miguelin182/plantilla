<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 10/09/2018
 * Time: 09:19 AM
 */

namespace App\Controllers;


use App\Models\Bitacora;
use App\Models\Cliente;
use App\Models\Credit;
use App\Repositories\BitacoraRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\CreditRepository;
use Core\Auth;
use Core\Controller;
use Illuminate\Support\Facades\Redirect;

class CreditController extends Controller
{
    private $clienteRepo;
    private $creditRepo;
    private $bitacoraRepo;
    public function __construct()
    {
        parent::__construct();
        $this->clienteRepo = new ClienteRepository();
        $this->creditRepo = new CreditRepository();
        $this->bitacoraRepo = new BitacoraRepository();
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

    public function getmyclients (){
        return $this->render('credit/myclients.twig', [
            'title' => 'Mis clientes'
        ]);
    }

    /**
     * Guarda un cliente nuevo a la base de datos
     */
    public function postGcliente(){
        $model = new Cliente();

        $empresa = Auth::getCurrentUser();
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

        $model2 = new Bitacora();

        $model2->id_emp = $empresa->id_emp;
        $model2->id_cli = $rh->result;
        $model2->accion = 1;

        $this->bitacoraRepo->Guardar($model2);

        print_r(
            json_encode($rh)
        );

    }

    public function postGcredito(){
        $model = new Credit();

        $empresa = Auth::getCurrentUser();
        if (isset($_POST['id_rel'])){
            $model->id_rel = $_POST['id_rel'];
        }
        $model->id_cli = $_POST['id_cli'];
        $model->id_emp = $empresa->id_emp;
        $model->monto = $_POST['monto'];
        $model->activo = $_POST['activo'];
        $model->plazo = $_POST['plazo'];
        $rh = $this->creditRepo->guardar($model);

        $model2 = new Bitacora();

        $model2->id_emp = $empresa->id_emp;
        $model2->id_cli = $_POST['id_cli'];
        $model2->accion = 2;

        $this->bitacoraRepo->Guardar($model2);

        print_r(
            json_encode($rh)
        );

    }

    public  function postGestado () {
        $model = new Credit();

        $model->id_rel = $_POST['id'];
        if ($_POST['estado'] == 1){
            $model->estado1 = $_POST['estado1'];
        }
        if ($_POST['estado'] == 2){
            $model->estado2 = $_POST['estado2'];
        }
        if ($_POST['estado'] == 3){
            $model->estado3 = $_POST['estado3'];
        }

        $rh = $this->creditRepo->actualizarEstado($model);

        print_r(
            json_encode($rh)
        );
    }

    public function postBuscarcredit() {
        print_r(
            json_encode($this->creditRepo->obtener($_POST['id']))
        );
    }

    public function postBuscarcrf() {
        print_r(
            json_encode($this->clienteRepo->buscarRfc($_POST['rfc']))
        );
    }

    public function postBuscarenombre() {
        $Usuario = Auth::getCurrentUser();
        print_r(
            json_encode($this->clienteRepo->listarE($_POST['nombre'],$Usuario->id_emp))
        );
    }

    public function postBuscarc(){
        $busqueda = $_POST['busqueda'];

        print_r(
            json_encode($this->clienteRepo->buscarRfc($busqueda))
        );
    }

    public function postObtenerc(){
        $Usuario = Auth::getCurrentUser();
        $id_cli = $_POST['id'];
        print_r(
            json_encode($this->creditRepo->listar($id_cli,$Usuario->id_emp))
        );
    }
    public function postUsuario(){
        print_r(
            json_encode(Auth::getCurrentUser())
        );
    }

    public function getClientedet($id){
        return $this->render('credit/clientedet.twig', [
            'title' => 'Detalle del cliente',
            'datos' => $this->creditRepo->listarsinemp($id),
            'cliente' => $this->clienteRepo->obtener($id)
        ]);
    }

    public function getcontview() {
        return $this->render('credit/contract.twig', [
            'title' => 'Detalle del cliente'
        ]);
    }

    public function getDowncont (){
        $finfo = finfo_open(FILEINFO_MIME);
        $content_type = finfo_file($finfo,_BASE_PATH_. "/download/Doc1.pdf");
        finfo_close($finfo);
        $file_name = basename(_BASE_PATH_. "/download/Doc1.pdf").PHP_EOL;
        $size = filesize(_BASE_PATH_. "/download/Doc1.pdf");
        header("Content-Type: $content_type");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Content-Transfer-Encoding: binary");
        header("Content-Lenght: $size");
        readfile(_BASE_PATH_. "/download/Doc1.pdf");
        return Redirect::back();
    }
}