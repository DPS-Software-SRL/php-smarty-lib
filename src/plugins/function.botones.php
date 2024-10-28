<?php

function smarty_function_botones( $params, $smarty ) {

    $bs = $smarty->getTemplateVars('tplBotones');

    if( ! $bs ) {
        return;
    }

    for( $i=0; $i<count($bs); $i++ )
    {
        // Si es un boton con accion = agregar (osea un boton NUEVO)
        // y no se tienen permisos suficientes se ignora el boton
        if( preg_match( '/accion=agregar/i', $bs[$i][1] ) && ! puedeEditar() ) {
          array_splice($bs, $i, 1);
          $i--;
          continue;
        }

        $bs[$i][3] = "";
        if( ( substr( trim( $bs[$i][0] ), -1 ) == '@' ) ) {
            $bs[$i][3] = "right";
            $bs[$i][0] = trim( substr($bs[$i][0], 0, -1) );
        }

        $bs[$i][4] = 'volver';

            
            $bs[$i][0] = preg_replace( "/(.*)(&)(.+?)(.*)/", "$1$3$4", $bs[$i][0] );
            if( ! empty($bs[$i][1]) )
            {
                $bs[$i][4] = 'js';
                if( strpos( $bs[$i][1], "javascript:" ) === false )
                {
                    $bs[$i][1] .= '&' . srand(); // hice esto porque CHROME me rompia las bolas trayendo una pagina desde cache ( creo )
                    $bs[$i][4] = 'php';
                }
            }
        //}
    }


    $smarty->assign('tplBotones', $bs );
}