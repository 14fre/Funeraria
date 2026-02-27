<?php

if (!function_exists('imagenes_para_vista')) {
    /**
     * Devuelve las rutas de imágenes (para asset()) que corresponden a una vista.
     * Solo incluye archivos que existan en public/images/ y que estén en config para esa vista.
     *
     * @param string $vista 'home'|'servicios'|'planes'|'obituarios'|'contacto'
     * @param int $max Máximo de imágenes a devolver (0 = todas)
     * @return array Lista de rutas tipo 'images/NOMBRE.jpg'
     */
    function imagenes_para_vista(string $vista, int $max = 0): array
    {
        $porVista = config('funeraria.imagenes_por_vista', []);
        $nombresOrden = $porVista[$vista] ?? [];
        if (empty($nombresOrden)) {
            return [];
        }

        $excluir = ['FUNE', 'ICONO', 'README', 'GITKEEP'];
        $carpeta = public_path('images');
        $encontradas = [];
        if (!is_dir($carpeta)) {
            return [];
        }
        $archivos = scandir($carpeta);
        foreach ($archivos as $archivo) {
            if ($archivo === '.' || $archivo === '..') {
                continue;
            }
            $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                continue;
            }
            $nombreBase = strtoupper(pathinfo($archivo, PATHINFO_FILENAME));
            if (in_array($nombreBase, array_map('strtoupper', $excluir), true)) {
                continue;
            }
            $encontradas[$nombreBase] = 'images/' . $archivo;
        }

        $resultado = [];
        foreach ($nombresOrden as $nombre) {
            $key = strtoupper($nombre);
            if (isset($encontradas[$key])) {
                $resultado[] = $encontradas[$key];
            }
        }
        if ($max > 0) {
            $resultado = array_slice($resultado, 0, $max);
        }
        return $resultado;
    }
}
