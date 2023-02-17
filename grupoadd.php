<?php
include 'ldap.php';

if ($ldapcon == true){
  $bind = ldap_bind($ldapcon, $user, $ldappass);
  if ($bind) {
      $group_dn = "CN=TI,CN=Groups,DC=local,DC=lab"; // DN do grupo "TI"
      $user_dn = "CN=hedwing bruno,$ldap_base_dn"; // DN do usuário "bruno" em "teste01"
      $resultado = ldap_mod_add($ldapcon, $group_dn, array("member" => $user_dn)); // Adiciona o usuário ao grupo
      if ($resultado === true) {
          echo "Usuário adicionado ao grupo com sucesso!";
      } else {
          echo "Não foi possível adicionar o usuário ao grupo.";
      }
  } else {
      echo "Não foi possível autenticar com as credenciais fornecidas.";
  }
} else {
  echo "Não foi possível conectar ao servidor LDAP.";
}
?>
