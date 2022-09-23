<?php

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;

if(! function_exists('appTitle') ){
    function appTitle(){
        return 'Best Place to Shop';
    }
}
if (!function_exists('__generateString')) {
    function __generateString($prefix, $table, $column, $length)
    {
        $key = TRUE;
        while ($key) {
            $generate     = $prefix . randomString($length);
            $check_id   = $table::where($column, $generate)->get()->first();
            if (empty($check_id)) {
                $key = FALSE;
            }
        }
        return $generate;
    }
}
if (!function_exists('randomString')) {
    function randomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}

if (!function_exists('rajaOngkir')) {
    function rajaOngkir($type = '', $method = 'get', $data = [])
    {
        $baseUrl = "https://api.rajaongkir.com/starter/";
        $apiUrl = $baseUrl . strtolower($type);
        $response = Http::withOptions([
            'verify' => false,
            'headers' => [
                'key' => "2361ebd8fff425b0efc4f0daaca0ddc6"
            ]
        ]);

        $res = new Response;

        switch($method){
            case 'get':
            case 'GET':
                $res = $response->get($apiUrl);
                break;
            case 'post':
            case 'POST':
                $res = $response->post($apiUrl, $data);
                break;
        }

        $response = json_decode($res->getBody(), true);
        return $response;
    }
}