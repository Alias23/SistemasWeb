sudo docker build -t="SistemasWeb-master" .
openssl genrsa -out llave.key 2048
openssl req -new -key llave.key -out servidor.csr
openssl x509 -req -days 365 -in servidor.csr -signkey llave.key -out certificado.crt
sudo docker-compose up
firefox "http://localhost:81/index.php"