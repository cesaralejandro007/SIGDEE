SET anio=%DATE:~-4%
SET mes=%DATE:~-7,2%
SET dia=%DATE:~-10,2%
SET nombre=bdsystem_%anio%%mes%%dia%.sql

mysqldump --user=root --port=3306 -p --no-create-info bdsystem > C:/xampp/htdocs/SIGDEE/content/respaldos/respaldos_diarios/%nombre%