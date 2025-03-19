# php-smarty-lib
Adaptación de Smarty para DPS

Al constructor se le puede pasar opcionalmente un array con formato similar al ejemplo, o al contenido del archivo `registrar.json`
Alli se nombran funciones o plugins que seran agregados a Smarty para poder ser usables en los .TPL

```
{
    "function": [

    ],
    "block": [

    ],
    "compiler": [

    ],
    "modifier": [
        "is_numeric",
        "strstr"
    ]
}
```
**Aprovecha si existen estas variables de $_ENV**

$_ENV['KINT_ENABLED'] y $_ENV['KINT_SHOW_DEBUGINFO_AL_PIE']
-
Si se habilitan, mostraran un debug de $_REQUEST, $_SESSION y $_ENV en cada pantalla
  
$_ENV['TEMPLATES_FOLDER']
- 
Carpeta donde buscar los archivos .TPL
Por default los busca en ``` $_ENV['PATH_ROOT'] \ TEMPLATES ```
