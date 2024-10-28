<?php

function smarty_function_lastVersion($params, Smarty_Internal_Template $template)
{
  if( stripos( $params['file'], '.js') ) {
    $file = $params['file'] . "?v=". filemtime( "{$_ENV['PATH_ROOT']}/{$params['file']}" );
    $defer = ( isset($params['defer']) ) ? ' defer ' : '';
    return "<script $defer language='JavaScript' src='$file'></script>";

  } elseif( stripos( $params['file'], '.css') ) {
    $file = $params['file'] . "?v=". filemtime( "{$_ENV['PATH_ROOT']}/{$params['file']}" );
    return "<link rel='stylesheet' type='text/css' href='$file'>";

  }

}
