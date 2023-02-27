<?php
include 'ldap.php';

$nome = $_GET['nome'];

$dn = "cn=".$nome.",ou=teste01,dc=local,dc=lab";
$mod = array();
$mod["userAccountControl"] = array(
  0 => "514",
);

$bind = ldap_modify($ldapcon, $dn, $mod);

if ($bind) {
  header('Location: index.php');
} 
else {
  echo "Error changing user account control: " . ldap_error($ldapcon);
}

ldap_close($ldapcon);
?>

