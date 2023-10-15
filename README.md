Para ejecutar nuestra pagina web deberas introducir los siguientes comandos en la terminal:

cd /A la ruta donde se encuentre el proyecto 

chmod +x init.sh

./init.sh

Ahora solo quedaria abrir firefox y escribir en la barra de busqueda la siguiente dirección:
localhost:81 o localhost:444 

Para parar la aplicaciones con poner el siguiente comando sera necesario:
docker-compose stop

En el caso de tener algun error con la creacion de la base de datos ejecutar los siguientes dos comandos:
docker-compose down
./init.sh

Autores : Xabier Badiola Guembe y Ander Martin Lopez
