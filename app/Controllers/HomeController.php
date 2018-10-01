<?php
namespace App\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\UrlHelper;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Usuario;
use App\Repositories\ClienteRepository;
use App\Repositories\UsuarioRepository;
use App\Validations\ClientValidation;
use Core\{Auth, Controller, Log};
use App\Repositories\EmpresaRepository;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
    private $usuarioRepo;
    private $empresaRepo;
    private $clienteRepo;
    private $authRepo;
    private $rh;

    public function __construct() {
        if(Auth::isLoggedIn()) {
            UrlHelper::redirect();
        }
        parent::__construct();
        $this->usuarioRepo = new UsuarioRepository();
        $this->empresaRepo = new EmpresaRepository();
        $this->clienteRepo = new ClienteRepository();
        $this->authRepo = new  UsuarioRepository();
    }

    public function getIndex() {
        return $this->render('home/index.twig', [
            'title' => 'Inicio'
        ]);
    }

    public function getArchiveblog () {
        return $this->render('home/archive-blog.twig', [
            'title' => 'Archive Blog'
        ]);
    }

    public function getSinglepost () {
        return $this->render('home/single-post.twig', [
            'title' => 'Single Post'
        ]);
    }

    public function getAboutus () {
        return $this->render('home/about-us.twig', [
            'title' => 'About us'
        ]);
    }

    public function getContact () {
        return $this->render('home/contact.twig', [
            'title' => 'About us'
        ]);
    }

    public function getTypography () {
        return $this->render('home/typography.twig', [
            'title' => 'Typography'
        ]);
    }

    public function getTramits (){
        return $this->render('home/tramits.twig', [
            'title' => 'Tramites'
        ]);
    }

    public function getConsults (){
        return $this->render('home/consults.twig', [
            'title' => 'Consultas'
        ]);
    }

    public function getLinked (){
        return $this->render('home/linked.twig', [
            'title' => 'Bases enlazadas'
        ]);
    }

    public function postSignin() {
        $rh = $this->usuarioRepo->autenticar(
            $_POST['email'],
            $_POST['password']
        );

        if($rh->response) {
            $rh->href = 'credit';
        }

        print_r(
            json_encode($rh)
        );
    }

    public function postGempresa(){
            $model = new Empresa();
            $model2 = new Usuario();
            if(isset($_POST['id_empresa'])){
                $model->id_empresa = $_POST['id_empresa'];
            }
            $model->razon_social = $_POST['razon_social'];
            $model->direccion = $_POST['direccion'];
            $model->email_empresa = $_POST['email_empresa'];
            $model->rfc = $_POST['rfc'];
            $model->telefono = $_POST['telefono'];
            $model->representante = $_POST['representante'];
            $model->email_representante = $_POST['email_representante'];
            $model->celular = $_POST['celular'];
            $model->giro = $_POST['giro'];

            if ($_POST['otro_sector'] != ''){
                $model->sector = $_POST['otro_sector'];
            } else {
                $model->sector = $_POST['sector'];
            }

            $model2->rol_id = 2;
            $model2->nombre = $_POST['razon_social'];
            $model2->email = $_POST['email_empresa'];
            $model2->password = $_POST['password'];
//            $model2->id_emp = $this->rh->result;

            $this->rh = $this->empresaRepo->guardar($model, $model2);


        print_r(
            json_encode($this->rh)
        );
    }
}