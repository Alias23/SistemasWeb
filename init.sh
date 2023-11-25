openssl genrsa -out llave.key 2048
openssl req -new -key llave.key -out servidor.csr
openssl x509 -req -days 365 -in servidor.csr -signkey llave.key -out certificado.crt
echo Creando base de datos...
echo Introduce la contraseña root
mysql -u root -e "CREATE DATABASE IF NOT EXISTS agendacontactos;"
echo Importando base de datos...
echo Introduce la contraseña root
mysql -u root -p agendacontactos < ./sql/setup.sql
echo Importación terminada
docker-compose up -d
