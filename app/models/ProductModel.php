<?php

class ProductModel{
    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=tpespecial;charset=utf8', 'root', '');
    }

    public function getAll(){
        $query = 'SELECT products.*, brands.name as brand, comments.comment as comment FROM products LEFT JOIN brands ON products.brand_ID = brands.brand_ID LEFT JOIN comments ON products.comment_ID = comments.comment_ID ';
        return $query;
    }

    public function prepare($query){
        $respuesta = $this->db->prepare($query);
        $respuesta->execute();
        return $respuesta->fetchAll(PDO::FETCH_OBJ);
    }
    
    function sortPageAndFilter($page, $limit, $sortBy, $order, $brand){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'WHERE brands.name= "' . $brand .' " ORDER BY ' . $sortBy . ' ' . $order.' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);
    }

    function filterAndPage($page, $limit, $brand){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'WHERE brands.name= "' . $brand .'" LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);
    }

    function sortAndFilter($sortBy, $order, $brand){
        $query = $this->getAll();
        $query .= 'WHERE brands.name= "' . $brand . '"'.'ORDER BY ' . $sortBy . ' ' . $order;
        return $this->prepare($query);
    }

    function sortAndPage($page, $limit, $sortBy, $order){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= 'ORDER BY ' . $sortBy . ' ' . $order . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);
    }


    function sort($sortBy = "product_ID", $order = "asc"){
        $query = $this->getAll();
        $query .= 'ORDER BY ' . $sortBy . ' ' . $order;
        return $this->prepare($query);
    }

    function filterBy($brand){
        $query = $this->getAll();
        $query .= 'WHERE brands.name= "' . $brand . '"';
        return $this->prepare($query);
    }


    function pagination($page, $limit){
        $query = $this->getAll();
        $offset = $page * $limit - $limit;
        $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        return $this->prepare($query);
    }


    public function get($id){
        $query = $this->db->prepare("SELECT products.*, brands.name as brand, comments.comment as comment FROM products LEFT JOIN brands ON products.brand_ID = brands.brand_ID LEFT JOIN comments ON products.comment_ID = comments.comment_ID WHERE product_id = ?");
        $query->execute(array($id));
        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    public function delete($id){
        $sentencia = $this->db->prepare("DELETE FROM products WHERE product_ID = ?");
        $response = $sentencia->execute(array($id));
    }

    public function insert($name, $milliliters, $price, $brand_ID, $comment_ID){
        $query = $this->db->prepare("INSERT INTO products (name, milliliters, price, brand_ID, comment_ID) VALUES (?,?, ?, ?, ?)");
        $query->execute([$name, $milliliters, $price, $brand_ID,$comment_ID]);

        return $this->db->lastInsertId();
    }

    public function editProduct($name, $milliliters, $price, $brand_ID,$comment_ID, $product_ID){
        $query = $this->db->prepare('UPDATE products SET name = ?, milliliters = ?, price = ?, brand_ID = ?, comment_ID = ?  WHERE product_ID = ?');
        $query->execute([$name, $milliliters, $price, $brand_ID,$comment_ID, $product_ID]);
    }
}
