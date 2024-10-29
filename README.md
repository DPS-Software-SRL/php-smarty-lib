# php-smarty-lib
Adaptación de Smarty para DPS


**Aprovecha si existen estas variables de $_ENV**

$_ENV['KINT_ENABLED'] y $_ENV['KINT_SHOW_DEBUGINFO_AL_PIE']
-
Si se habilitan, mostraran un debug de $_REQUEST, $_SESSION y $_ENV en cada pantalla
  
$_ENV['TEMPLATES_FOLDER']
- 
Carpeta donde buscar los archivos .TPL
Por default los busca en ``` $_ENV['PATH_ROOT'] \ TEMPLATES ```
