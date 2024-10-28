<?php

namespace Dps;

use Cekurte\Environment\Environment as env;

class Smartydps extends Smarty {

    public function __construct() {
        parent::__construct();

        // $smarty = new SmartyDPS();
        
        require_once( __DIR__ . "/plugins/function.lastVersion.php" );
        require_once( __DIR__ . "/plugins/function.botones.php" );
        require_once( __DIR__ . "/plugins/function.gitBranch.php" );
        
        $this->setTemplateDir( "{$_ENV['PATH_ROOT']}/templates" );
        $this->setCompileDir( '/tmp' );
        
        // Cada Funcion PHP que se quiera usar dentro de los TPL debe primero ser registrada.
        $this->registerPlugin( 'modifier', 'strstr', 'strstr' );
        $this->registerPlugin( 'modifier', 'is_numeric', 'is_numeric' );
        
        $this->error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING;
        
        // Esta linea setea un dato para UPD.TPL
        if( isset( $_REQUEST['aceptar_y_nuevo'] ) ) {
          $this->assign('aceptar_y_nuevo', true);
        }
        
        if( isset( $_REQUEST['forceReloadAfterUpd'] ) ) {
          $this->assign('forceReloadAfterUpd', true);
        }
        
                
    }

    public function mostrar( $template ) {
        if( env::get('KINT_ENABLED') && env::get('KINT_SHOW_DEBUGINFO_AL_PIE')  ) {
            $old = Kint\Renderer\RichRenderer::$folder;
            Kint\Renderer\RichRenderer::$folder = true;
            d( [$_REQUEST, $_SESSION, $_ENV] );
            Kint\Renderer\RichRenderer::$folder = $old;
        }

        // $_SESSION['dpsListaTemplates'] = array('contenido.tpl');
        $this->assign( 'mostrarTemplate', $template );
        $this->assign( 'libFormy', ( ( array_key_exists( 'libFormy', $this->getTemplateVars()) || $template == 'formy.tpl') ) );
        $this->assign( 'libGrilla', ( ( array_key_exists( 'libGrilla', $this->getTemplateVars()) || $template == 'abm.tpl') ) );
        $this->display( 'contenido.tpl' );
    }

}

