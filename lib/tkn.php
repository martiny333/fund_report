<?php

require_once __DIR__ . '/../config/config.php';

function getToken($env)
{
    $post_data = [
        "username" => myConfig('AUTH', 'username'),
        "password" => myConfig('AUTH', 'password'),
    ];  

    $env = myConfig('ENV', $env);
    $api_url = myConfig($env, 'api');
    $query = '/authn/login';

    $request_url = $api_url.$query;

    $curl = curl_init($request_url);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt(
        $curl, CURLOPT_HTTPHEADER, [
            'X-okapi-Host: '. $api_url,
            'Content-Type: application/json',
            'x-okapi-tenant:{tenant_name}'   //enter netant name here
        ]
    );

    $response = curl_exec($curl);

    if ($response === false) {
        ob_end_clean();
        print_r(curl_error($curl));
        exit(0);
    }

    curl_close($curl);
    $arr = json_decode($response, true);

    return $arr['okapiToken']."\n";
}

