<?php

namespace Dps;

use Smarty;
use Cekurte\Environment\Environment as env;
use Kint\Renderer\RichRenderer;


/**
 * Adaptacion de Smarty a DPS
 * 
 * @requires $_ENV['KINT_ENABLED'] 
 * @requires $_ENV['KINT_SHOW_DEBUGINFO_AL_PIE']
 * @requires $_ENV['TEMPLATES_FOLDER']
 */
class Smartydps extends Smarty {

    private $tplFormy     = 'formy.tpl';
    private $tplGrilla    = 'abm.tpl';
    private $tplContenido = 'contenido.tpl';

    /**
     * Instancia de Smarty
     * @param string $registerPluginsData Array con los plugins a registrar. Similar al contenido de registrar.json de esta libreria
     */
    public function __construct( array $registerPluginsData = []) {
        parent::__construct();

        $this->error_reporting = E_ALL ^ E_NOTICE ^ E_WARNING;

        // incluye a todos los archivos encontrados en la carpeta plugins
        foreach( glob( __DIR__ . "/plugins/function.*.php" ) as $filePlugin ) {
            require $filePlugin;
        }

        $this->setTemplateDir( env::get('TEMPLATES_FOLDER', "{$_ENV['PATH_ROOT']}/templates" ) );
        $this->setCompileDir( '/tmp' );

        // Registrar plugins declarados en registrar.json
        $this->registrarPlugins( json_decode( file_get_contents( __DIR__ . "/registrar.json" ) ) );                
        
        // Registrar plugins pasados por parametro
        $this->registrarPlugins( $registerPluginsData );

    }

    
    private function registrarPlugins( $json ) {
        foreach( $json as $tipo => $valores ) {
            foreach( $valores as $valor ) {
                $this->registerPlugin( $tipo, $valor, $valor );
            }
        }
    }


    public function mostrar( $template ) {
        // Mostrar un DEBUG al pie si está configurado
        if( env::get('KINT_ENABLED', false) && env::get('KINT_SHOW_DEBUGINFO_AL_PIE', false)  ) {
            $old = RichRenderer::$folder;
            RichRenderer::$folder = true;
            d( [$_REQUEST, $_SESSION, $_ENV] );
            RichRenderer::$folder = $old;
        }

        // Estas lineas setean un dato para UPD.TPL
        if( isset( $_REQUEST['aceptar_y_nuevo'] ) ) {
            $this->assign('aceptar_y_nuevo', true);
        }
        
        if( isset( $_REQUEST['forceReloadAfterUpd'] ) ) {
            $this->assign('forceReloadAfterUpd', true);
        }
        
        // Permitira cargar en head.tpl los css y js de Formy
        $this->assign( 'libFormy', ( ( array_key_exists( 'libFormy', $this->getTemplateVars()) || $template == $this->tplFormy ) ) );
        
        // Permitira cargar en head.tpl los css y js de las grillas
        $this->assign( 'libGrilla', ( ( array_key_exists( 'libGrilla', $this->getTemplateVars()) || $template == $this->tplGrilla  ) ) );

        // Mostrar el template solicitado
        $this->assign( 'mostrarTemplate', $template );
        $this->display( $this->tplContenido );
    }

}

