<?php

header('Content-Type: application/json');
require_once '../../model/RoleDao.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_REQUEST['id'] ?? null;

if ($method == 'GET' && !$id) index();
if ($method == 'GET' && $id) show($id);
if ($method == 'POST') store();
if ($method == 'PUT' && $id) update($id);
if ($method == 'DELETE' ) destroy($id);

function index(){
    $dao = new RoleDao();
    $roles = $dao->GetAll();
    $result = ['data'=>[]];
    foreach ($roles as $roles) {
        $result['data'][] = [
            'id'=>$roles->getId(),
            'titulo' => $roles->getTitle(),
        ];
    }
    echo json_encode($result);
    exit;
}

function show($id){
    $dao = new RoleDao();
    $role = $dao->GetById($id);
    if ($role) {
        echo json_encode([
            'data'=>[
                'id'=>$role->getId(),
                'titulo' => $role->getTitle(),
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
    $data = json_decode(file_get_contents('php://input'));
    $dao = new RoleDao();
    $role =array();
    if ($role) {
        http_response_code(404);
        echo json_encode(['msg'=>'El usuario ya a sido registrado, por favor verifique e intente nuevamente.']);
        exit;
    }else {
        $role =[
            'title' => $data->title
        ];
        if ($dao->store($role)) {
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
    $dao = new RoleDao();
    $role =array();
    if ($dao->GetById($id)) {
        if ($role) {
            http_response_code(404);
            echo json_encode(['msg'=>'El usuario ya a sido registrado, por favor verifique e intente nuevamente.']);
            exit;
        }else {
            $role =[
                'title' => $data->title
            ];
            if ($dao->update($role,$id)) {
                http_response_code('201');
                echo json_encode(['msg'=>'Datos actualizados correctamente.']);
                exit;
            }            
        }
    }    
    http_response_code('500');
    echo json_encode(['msg'=>'No ha sido posible actualizar los datos, por favor verifique e intente nuevamente.']);
    exit;
    
}

function destroy($id){
    $dao = new RoleDao();
    $item = $dao->GetById($id);
    if ($item) {
        if ($dao->delete($id)) {
            http_response_code('201');
            echo json_encode(['msg'=>'Datos eliminados correctamente.']);
            exit;
        }
    }
    http_response_code('500');
    echo json_encode(['msg'=>'No ha sido posible eliminar los datos, por favor verifique e intente nuevamente.']);
    exit;
    
    
}