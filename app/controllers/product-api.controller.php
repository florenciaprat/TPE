<?php
require_once './app/models/ProductModel.php';
require_once './app/views/apiView.php';

class productApiController{
    private $model;
    private $view;
    private $data;

    public function __construct(){
        $this->model = new ProductModel();
        $this->view = new ApiView();
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data); //convertir el string recibido a json
    }

    public function getProducts(){
        $order = $_GET['order'] ?? null; //el valor puede ser null
        $sortBy = $_GET['sort'] ?? null;
        $page =  $_GET['page'] ?? null;
        $limit = $_GET['limit'] ?? null;
        $brand = $_GET['brand'] ?? null;

        $columns = array('product_ID', 'name', 'milliliters', 'price', 'brand_ID', 'comment_ID');
        $orden = array('asc', 'desc');
        $brands = array('bagovit', 'garnier','neutrogena', 'nivea');


        //si el paginado esta bien, si la columna esta en mi tabla y si hay filtrado bien
        if ((is_numeric($page)&& ($page!=0) && is_numeric($limit)) && (in_array($sortBy, $columns) && in_array($order, $orden)) && in_array($brand, $brands)) {
            $products = $this->model->sortPageAndFilter($page, $limit, $sortBy, $order, $brand);

            $this->view->response($products); //si pongo pag 100 esta bien el arreglo vacio y el 200 porque no hay mas productos   
        } else if ((is_numeric($page) && ($page!=0)&& is_numeric($limit)) && (in_array($sortBy, $columns) && in_array($order, $orden))) {
            $products = $this->model->sortAndPage($page, $limit, $sortBy, $order);
            $this->view->response($products);
        } else if ((in_array($sortBy, $columns) && in_array($order, $orden)) && in_array($brand, $brands)&& empty($page) && empty($limit)) {
            $products = $this->model->sortAndFilter($sortBy, $order, $brand);
            $this->view->response($products);
        } else if ((is_numeric($page) && ($page!=0)&& is_numeric($limit)) && in_array($brand, $brands)&& empty($sortBy)&&empty($order)) {
            $products = $this->model->filterAndPage($page, $limit, $brand);
            $this->view->response($products);
        } else if (is_numeric($page)&& ($page!=0) && is_numeric($limit)&&empty($sortBy)&&empty($order)&&empty($brand)) {
            $products = $this->model->pagination($page, $limit);
            $this->view->response($products);
        } else if (in_array($sortBy, $columns) && in_array($order, $orden)&&empty($page)&&empty($limit)) {
            $products = $this->model->sort($sortBy, $order);
            $this->view->response($products);
        }else if (in_array($brand, $brands) && empty($sort) && empty($order) && empty($page) && empty($limit)) {
              $products = $this->model->filterBy($brand);
              $this->view->response($products);
        }else if((empty($page) && empty($limit)) && empty($sortBy) && empty($order) && empty($brand)){
            $products = $this->model->sort();
            $this->view->response($products);
        } else {
            $this->view->response("Verifique que lo ingresado sea correcto", 404);
        }
    } //el recurso productos existe aunque sea vacio entonces esta bien el 200


    public function getProduct($params = null){
        // obtengo el id del arreglo de params
        $id = $params[':ID'];
        $product = $this->model->get($id);

        // si no existe devuelvo 404
        if ($product)
            $this->view->response($product);
        else
            $this->view->response("El producto con el id= $id no existe", 404);
    }

    public function deleteProduct($params = null){
        $id = $params[':ID'];

        $product = $this->model->get($id);
        if ($product) { //si existe el producto la borro
            $this->model->delete($id);
            $this->view->response('El producto fue eliminado');
        } else
            $this->view->response("El producto con el id=$id no existe", 404);
    }

    public function insertProduct($params = null){
         $product = $this->getData();
        if (empty($product->name) || empty($product->milliliters) || empty($product->price) || empty($product->brand_ID)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($product->name, $product->milliliters, $product->price, $product->brand_ID, $product->comment_ID);
            $product = $this->model->get($id);
            $this->view->response("El producto se inserto con el id = $id", 201);
        }
    }

    public function updateProduct($params = null){
        $id = $params[':ID'];
        $body = $this->getData();
        $product = $this->model->get($id);

        if (empty($product->name) || empty($product->milliliters) || empty($product->price) || empty($product->brand_ID)) {
            $this->view->response("Complete los datos", 400);
        } else {
            if ($product) {
                $this->model->editProduct($body->name, $body->milliliters, $body->price, $body->brand_ID,$body->comment_ID, $id);
                $this->view->response("El producto se actualizó con exito", 200);
            } else {
                $this->view->response("El producto con el id= $id no existe", 404);
            }
        }
    }
}