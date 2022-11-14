<?php
require_once './app/models/UserModel.php';
require_once './app/views/apiView.php';
require_once './app/helpers/auth-api.helper.php';
require_once './app/models/UserModel.php';

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
} //por el tema de la pagina para confirmar el token


class AuthApiController{
    private $model;
    private $view;
    private $authHelper;
    private $userModel;
    private $data;

    public function __construct(){
        $this->model = new UserModel();
        $this->view = new ApiView();
        $this->authHelper = new AuthApiHelper();
        $this->userModel = new UserModel();

        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    public function getToken($params = null){
        // Obtener "Basic base64(user:pass)
        //leer el header
        $basic = $this->authHelper->getAuthHeader();

        if (empty($basic)) {
            $this->view->response('No autorizado', 401);
            return;
        }
        $basic = explode(" ", $basic); // ["Basic" "base64(user:pass)"]
        if ($basic[0] != "Basic") {
            $this->view->response('La autenticación debe ser Basic', 401);
            return;
        }

        //validar usuario:contraseña
        $userpass = base64_decode($basic[1]); // user:pass
        $userpass = explode(":", $userpass);
        $user = $userpass[0];
        $pass = $userpass[1];

        //$user=$this->userModel->
        
        $user = $this->model->getUserByEmail($user);
        var_dump($user);

        if ($user == "Nico" && $pass == "web") {
            //  crear un token
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );
            $payload = array(
                'id' => 1,
                'name' => "Nico",
                'exp' => time() + 3600
            );
            $header = base64url_encode(json_encode($header));
            $payload = base64url_encode(json_encode($payload));
            $signature = hash_hmac('SHA256', "$header.$payload", "Clave1234", true);
            $signature = base64url_encode($signature);
            $token = "$header.$payload.$signature";
            $this->view->response($token);
        } else {
            $this->view->response('No autorizado', 401);
        }
    }
}
