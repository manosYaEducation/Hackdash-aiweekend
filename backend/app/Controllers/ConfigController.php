<?php

namespace App\Backend\Controllers;

class ConfigController
{
    public function getConfig()
    {
        try {
            // Leer configuración desde config.ini
            $config = parse_ini_file(__DIR__ . "/../../../config.ini", true);
            
            // Detectar esquema y host
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            
            // Construir URLs dinámicas
            $baseUrl = $scheme . '://' . $host;
            $apiUrl = $baseUrl . $config['paths']['backend'];
            $frontendUrl = $baseUrl . $config['paths']['frontend'];
            
            $response = [
                'base_url' => $baseUrl,
                'api_url' => $apiUrl,
                'frontend_url' => $frontendUrl,
                'environment' => $config['environment']['development'] ? 'development' : 'production'
            ];
            
            // Establecer headers para JSON
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
            
            return json_encode($response);
            
        } catch (Exception $e) {
            // En caso de error, devolver configuración por defecto
            $response = [
                'base_url' => 'http://localhost',
                'api_url' => 'http://localhost/hackdash-aiweekend/backend',
                'frontend_url' => 'http://localhost/hackdash-aiweekend/frontend',
                'environment' => 'development'
            ];
            
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET');
            
            return json_encode($response);
        }
    }
}

