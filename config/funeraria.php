<?php

return [

    'nombre' => 'Funeraria San José del Huila',
    'direccion_principal' => 'Calle 9 Nro. 13-50 - Altico',
    'ciudad' => 'Neiva - Huila (Colombia)',
    'telefonos' => ['3186298729', '3186298688', '3176413998'],
    'email' => 'comercial@funerariasanjose.co',

    'sedes' => [
        [
            'nombre' => 'Neiva',
            'direccion' => 'Calle 9 Nro. 13-50',
            'detalle' => 'Altico',
            'telefono' => '3186298729',
        ],
        [
            'nombre' => 'Parque Crematorio',
            'direccion' => 'Km 1 Vía Fortalecillas',
            'detalle' => null,
            'telefono' => '3152094373',
        ],
        [
            'nombre' => 'La Plata',
            'direccion' => 'Calle 4 Nro. 2-17',
            'detalle' => null,
            'telefono' => '3174368794',
        ],
        [
            'nombre' => 'Yaguará',
            'direccion' => 'Carrera 2 Nro. 5-78',
            'detalle' => null,
            'telefono' => '3118347886',
        ],
        [
            'nombre' => 'Natagaima',
            'direccion' => 'Calle 7 Nro. 5-33',
            'detalle' => null,
            'telefono' => '3176437058',
        ],
    ],

    /*
    | Videos de la sección "Quiénes somos" (Inicio).
    | Colocar archivos en public/videos/
    */
    'video_mp4' => 'videos/Video.mp4',
    'video_webm' => 'videos/VIDEO2.webm',

    /*
    | Imágenes para la franja bajo "Nuestros Servicios" (Inicio).
    | Nombres en mayúsculas como en la carpeta public/images/.
    | Se busca automáticamente extensión .jpg, .jpeg, .png, .webp
    */
    'imagenes_servicio' => [
        '2COBERTURA',
        'REUNION',
        'FIRMAR',
        'CARRO',
        'VELAS',
        'TASAS',
        'FLORES1',
        'FLORES',
        'ATAUD2',
    ],

    /*
    | Distribución de imágenes por vista (solo las que apliquen a cada página).
    | Clave = vista (home, servicios, planes, obituarios, contacto).
    | Valor = nombres (sin extensión) en el orden deseado; se muestran solo las que existan en public/images/
    */
    'imagenes_por_vista' => [
        'home'         => ['REUNION', 'CARRO', 'VELAS', 'FLORES', 'ATAUD2'],
        'servicios'    => ['CARRO', 'VELAS', 'TASAS', 'FLORES', 'ATAUD2'],
        'planes'       => ['REUNION', 'FIRMAR'],
        'obituarios'   => ['FLORES', 'VELAS'],
        'contacto'     => ['REUNION', '2COBERTURA'],
        'quienes_somos'=> ['REUNION', 'FLORES', 'VELAS', 'COBERTURA'],
    ],

];
