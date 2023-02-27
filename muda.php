<?php
include 'ldap.php';

$name = 'thiago17';

$dn = "cn=$name,OU=teste01,DC=local,DC=lab";

    if ($ldapcon == true){

      $info["useraccountcontrol"]= '514';

      ldap_modify($ldapcon, $dn, $info);

      ldap_close($ldapcon);

    } else{

      echo "Não conectado";
        
    }

?> 