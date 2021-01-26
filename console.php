<?php

print_r("START CLEANING AND UPDATES\r\n\r\n");

exec('php bin/console c:c -e prod');
print_r("Nettoyage cache PROD : OK\r\n");

exec('php bin/console d:s:u -f');
print_r("Update DataBase : OK\r\n\r\n");

print_r("END CLEANING AND UPDATES");