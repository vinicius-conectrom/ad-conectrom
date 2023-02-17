<?php
$username = 'bruno';
$password = 'sistemas251186';
$ldap_server = "192.168.56.109";
$dominio = "@local.lab";
$user = $username.$dominio;
$ldap_porta = "389";
$ldappass   = $password;
$ldap_base_dn = 'OU=teste01,DC=local,DC=lab';

$ldapcon = ldap_connect($ldap_server, $ldap_porta) or 
die("Não foi possível conectar ao servidor LDAP.");

if ($ldapcon == true){

$bind = ldap_bind($ldapcon, $user, $ldappass);
    
}else {

echo "Não conectado";

}