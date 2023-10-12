sudo docker build -t="agendacontactos" .
openssl genrsa -out llave.key 2048
openssl req -new -key llave.key -out servidor.csr
openssl x509 -req -days 365 -in servidor.csr -signkey llave.key -out certificado.crt
echo Importando base de datos...
sudo mysql -u root -p agendacontactos < ./sql/setup.sql
sudo docker-compose up
firefox "http://localhost:81/index.php"
