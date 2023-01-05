docker build -t="sistemasweb-master" .
openssl genrsa -out llave.key 2048
openssl req -new -key llave.key -out servidor.csr
openssl x509 -req -days 365 -r servidor.csr -signkey llave.key -out certificado.crt
start firefox "http://localhost:81/index.php"
docker-compose up
