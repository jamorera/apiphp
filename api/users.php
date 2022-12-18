<?php

header('Content-Type: application/json');
require_once '../model/UserDao.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_REQUEST['id'] ?? null;

if ($method == 'GET' && !$id) index();
if ($method == 'GET' && $id) show($id);
if ($method == 'POST') store($id);
if ($method == 'PUT' ) update($id);
if ($method == 'DELETE' ) destroy($id);


function index(){
    $dao = new UserDao();
    $users = $dao->GetAll();
    $result = ['data'=>[]];
    foreach ($users as $user) {
        $result['data'][] = [
            'id'=>$user->getId(),
            'name' => $user->getName(),
            'lastName' => $user->getLastName(),
            'Years' => $user->getYears(),
            'email' => $user->getEmail(),
            'Image' => $user->getImage(),
            'DocumentType' => $user->getDocumentType()
        ];
    }
    echo json_encode($result);
    exit;
}

function show($id){
    $dao = new UserDao();
    $user = $dao->GetById($id);
    if ($user) {
        echo json_encode([
            'data'=>[
                'id'=>$user->getId(),
                'name' => $user->getName(),
                'lastName' => $user->getLastName(),
                'Years' => $user->getYears(),
                'email' => $user->getEmail(),
                'Image' => $user->getImage(),
                'DocumentType' => $user->getDocumentType()
            ]
        ]);
        exit;
    }else{
        http_response_code(404);
        echo json_encode(['msg'=>'No ha sido posible realizar proceso, por favor verifique e intente nuevamente.']);
        exit;
    }
}

function store(){
    // $data = json_decode(file_get_contents('php://input'));
    $dao = new UserDao();
    $user = $dao->GetByEmail($_POST['email']);
    $user =array();
    $ruta = '/apiphp/assets/img/';
    $nameImg = $_FILES['image']['name']; 
    $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].$ruta;
    if ($user) {
        http_response_code(404);
        echo json_encode(['msg'=>'El usuario ya a sido registrado, por favor verifique e intente nuevamente.']);
        exit;
    }else {
        $user =[
            'name' => $_POST['name'],
            'lastName' => $_POST['lastName'],
            'years' => $_POST['years'],
            'email' => $_POST['email'],
            'image' => $ruta.$nameImg,
            'documentType' => $_POST['documentType'],
        ];
        if ($dao->store($user)) {
            move_uploaded_file($_FILES['image']['tmp_name'],$carpeta_destino.$nameImg);
            http_response_code('201');
            echo json_encode(['msg'=>'Datos registrados correctamente.']);
            exit;
        }
        http_response_code('500');
        echo json_encode(['msg'=>'No ha sido posible registrar los datos, por favor verifique e intente nuevamente.']);
        exit;
    }
    
}

function update($id){
    $data = json_decode(file_get_contents('php://input'));
    $dao = new UserDao();
    $user =array();
    if ($dao->GetById($id)) {
        if ($user) {
            http_response_code(404);
            echo json_encode(['msg'=>'El usuario ya a sido registrado, por favor verifique e intente nuevamente.']);
            exit;
        }else {
            $user =[
                'name' => $data->name,
                'lastName' => $data->lastName,
                'years' => $data->years,
                'email' => $data->email,
                'image' => $data->image,
                'documentType' => $data->documentType,
            ];
            if ($dao->update($user,$id)) {
                http_response_code('201');
                echo json_encode(['msg'=>'Datos registrados correctamente.']);
                exit;
            }            
        }
    }    
    http_response_code('500');
    echo json_encode(['msg'=>'No ha sido posible actualizar los datos, por favor verifique e intente nuevamente.']);
    exit;
    
}

function destroy($id){
    $dao = new UserDao();
    if ($dao->GetById($id)) {
        if ($dao->delete($id)) {
            http_response_code('201');
            echo json_encode(['msg'=>'Datos registrados correctamente.']);
            exit;
        }
    }
    http_response_code('500');
    echo json_encode(['msg'=>'No ha sido posible eliminar los datos, por favor verifique e intente nuevamente.']);
    exit;
    
    
}