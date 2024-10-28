<?php

use Cekurte\Environment\Environment as env;

/**
  * Smarty Function
  *
  * Return GIT Branch name en un DIV
  * Usar en un TPL con la sintaxis {gitBranch}
  *
  * Para que esta idea funcione hay que:
  *   1. Crear el archivo: .git/hooks/post-checkout  
  *   2. El contenido del archivo deberá ser este:
  *     #!/bin/sh
  *     git branch --show-current > public/.gitbranch
  *   3. En linux al menos, hay que setear ese archivo como ejecutable:
  *      chmod +x .git/hooks/post-checkout
  *   4. Ojo: Adaptar la ruta indicada para ".gitbranch" ya que 
  *      debe quedar en la carpeta raiz publica del proyecto
  *   5. Luego en cada cambio de rama automagicamente este archivo cambiará su contenido
  *   6. Incluir al archivo public/.gitbranch en .gitignore
  *   7. Usa la variable de entorno SHOW_GIT_BRANCH para mostrar el branch en el tpl
  *
  * @return string 
  */
  
  function smarty_function_gitBranch( $params, $smarty ) 
  {
    $html   = '';    
    $branch = '';

    $prefix = $params['prefix'] ?? 'git branch: ';

    if( env::get('SHOW_GIT_BRANCH', false) ) {
      $path   = "{$_ENV['PATH_ROOT']}/.gitbranch";
      if (file_exists($path)) {
        $branch = $prefix . trim(file_get_contents($path));
        $html = "<div id='gitbranch' style=' position: absolute; bottom: 0px; right: 0px; opacity: .3; font-size: .8em; '>$branch</div>";
      }   
    }
   
    return $html;
  }  