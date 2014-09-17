Vía Pública on line Madero
========================

Bienvenidos a la aplicacion de Via Publica online Madero.

1) Installing the Standard Edition
----------------------------------

Instalacion composer.

Las instrucciones para instalar composer estan en la siguiente direccion
http://getcomposer.org/ or solo poner en consola el siguiente comando:

    curl -s http://getcomposer.org/installer | php

### Instalar vendors

Utilizar el siguiente comando.

    php composer.phar install

2) Checar configuracion del sistema.
-------------------------------------

Antes de iniciar, revisar la configuracion de su sistema con el siguiente comando.

    php app/check.php

O accesar a la siguiente direccion de su proyecto.

    http://localhost/path/to/symfony/app/web/config.php

3) Configuraciones adicionales.

### Configuracion de editor tinyMCE

Ir a la siguiente ruta dentro de la carpeta del proyecto. 

    app/config/config_prod.yml

Cambiar la propiedad base_url por la direccion correcta: 

    stfalcon_tinymce:
            ...
            base_url: "http://www.viamadero.com/" 

4) Configurar las rutuas

Hacer el cambio de las rutas de amazon "/apps/madero/web" por las de produccion.

5) Crear carpeta de carga de imagenes con permisos de 777. 

    /web/upload
    /web/upload/galerias
