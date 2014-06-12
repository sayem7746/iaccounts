 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ldap {

 public function validar($usuario,$password) {
  $dominio = '<mydomain>';
  $servidor = '<ip_ldap_server>';
  $ldaprdn =  $dominio . "\\" . $usuario;
  $ldappass = $password;
  $ldapconn = ldap_connect($servidor )
      or die("Could not connect to LDAP server.");
  
  if ($ldapconn)  {
      $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);

      if (($ldapbind) and ($password != '')) {
          $estado = 'OK';
      } else {
          $estado = 'ERROR';
      }
  }
  ldap_close($ldapconn);
  return $estado;  
 }
}