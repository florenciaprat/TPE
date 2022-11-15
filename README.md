# Products API
Esta API REST nos permite manejar un CRUD de productos trayendo toda su informacion la cual se puede ordenar, paginar y filtrar por marca.

## Importar base de datos
Desde phpMyAdmin importar database/tpespecial.sql.

Se registran los productos en una tabla y las marcas en otra.

Products contiene las siguientes columnas: **(int) product_ID, (varchar) "name", (int) "milliliters", (double) "price", (int) brand_ID**. brand_ID es una clave foranea que que se relaciona con la tabla brands.

Brands contiene las siguientes columnas: **(int) brand_ID, (varchar) "name", (varchar) "country", (int) "foundation", (varchar) "website"**. 



 
# Requests
### Prueba desde postman
Se debe colocar la siguiente URL http://localhost/Skincare-rest/api/products

## GET (ALL)
Para obtener todos los registros

verbo: GET

http://localhost/Skincare-rest/api/products

## Listar solo un producto:
verbo: GET

http://localhost/Skincare-rest/api/products/:id


## Crear un nuevo producto:
verbo: POST

Para crearlo deberiamos colocar en el body un objeto con los siguientes campos completos:
{
        "name": ---
        "milliliters": ---
        "price": ---
        "brand_ID": ---
        "comment_ID":---
}

El name es un string, milliliters y price son enteros, brand_ID hace referencia 
al id de una marca que se tiene que encotrar en la tabla brands, comment_ID
hace referencia a un comentario en la tabla comments pero tambien puede no agregarse
un comentario mandando null.


## Borrar un producto:
verbo: DELETE

http://localhost/Skincare-rest/api/products/:id

## Editar un producto:
verbo: PUT

http://localhost/Skincare-rest/api/products/:id

Para editar un producto se debe colocar en la url el id del producto que se quiere editar y en el body el json con los nuevos valores de los campos.


## Filtrado:
Solo se podra filtrar por marca, para hacerlo a nuestra url se le agrega el parametro
brand seguido de lo que se quiere filtrar:
http://localhost/Skincare-rest/api/products?brand=nivea

El ejemplo nos devolvera todos los productos de la marca nivea.

## Orden: 
Para que la lista de productos se puestre ordenada por uno de sus campos de forma ascendente
o descendente debemos agregarle a la url el parametro sort y order(asc o desc):
http://localhost/Skincare-rest/api/products?sort=name&order=desc

El ejemplo nos devolveria todos los productos ordenados por nombre de forma descendente.

## Paginacion:
Para paginar los productos debemos agregar los parametros page y limit, donde el page indica
el numero de pagina y el limit la cantidad de productos que queremos ver por pagina:
http://localhost/Skincare-rest/api/products?page=1&limit=2

El ejemplo nos devolveria los 2 productos que se encuentran en la pagina 1.


Los 3 items anteriores pueden combinarse entre si, asi sean 2 o 3, por ejemplo:

http://localhost/Skincare-rest/api/products?sort=name&order=desc&page=1&limit=2, se ordena
por nombre de manera descendente y al mismo tiempo se pagina.

Ejemplo con los 3 items: http://localhost/Skincare-rest/api/products?sort=name&order=desc&page=1&limit=2&brand=nivea, todos los productos
resultantes del filtrado se van a ordenar y paginar.

## Codigos de respuesta:
|Status| Mensaje    |Significado
|----  |:----------:|-----------------------------------------------------:
|200   |OK          | si la solicitud ha tenido exito.
|201   |Created     | como resultado de la solicitus se ha creado un nuevo recurso.
|400   | Bad Request| indica que el servidor no puede procesar la peticion debido a un error del cliente.
|404   |Not Found   |indica que el host ha sido capaz de comunicarse con el servidor, pero no existe el recurso que ha sido pedido.

## Resumen
|Route		      | Method	  |   Description
|---------------|:---------:|-----------------------------------------------------:
|/products	    | GET	      | Retorna todos los productos
|/products/:id 	|GET	      | Retorna un producto con el id especificado
|/products	    |  POST	    |Se crea un nuevo producto con lo colocado en el body
|/products/:id	| DELETE	  |Borra el producto con el id especificado
|/products/:id	|  PUT	    | Edita el producto con el id especificado
