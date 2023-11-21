<?php

require_once __DIR__ . '/../config/config.php';

/*===================================*/
/*FUNCTION to invocate an API call . */
/*===================================*/

function getFolioData($query, $method="GET", $data_string="")
{
    $app = $GLOBALS['app'] ?? 'default';
    $GLOBALS['token'] = $GLOBALS['token'] ?? getToken($app);
    $env = myConfig('ENV', $app);
    $api_url = myConfig($env, 'api');

    $request_url = $api_url.$query;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    if($method=="GET") {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");                         
    }

    if($method=="DELETE") {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);                            
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);                     
    }
    if($method=="PUT") {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);                            
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);                     
    }

    if($method=="POST") {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);                            
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);                     
        curl_setopt($curl, CURLOPT_POST, true);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt(
        $curl, CURLOPT_HTTPHEADER, [
            'X-okapi-Host: '. $api_url,
            'X-okapi-token: '.$GLOBALS['token'],
            'Content-Type: application/json'
        ]
    );

    $response = curl_exec($curl);

    $error = "";
    $arr = array('error');
    if($response === false) {
        $error = curl_error($curl);
    }
    else {
        $arr = json_decode($response, true);
        if (is_null($arr)) {
            $error = "Error retrieving results.<br>";
        }
    }
    curl_close($curl);

    if (!empty($error)) {
        //ob_end_clean();
        print_r($error);
        exit(0);
    }

    return $arr;
}

/*==========================*/
/* FUNCTION idConc($id, $from="uuid"/"hrid",$rectype="in/it/ho",$server="TEST/PROD"*/
/*==========================*/


FUNCTION idConv($id,$from,$rectype)
{

    $qin='/instance-storage/instances?query=';
    $qit='/inventory/items?query=';
    $qho='/holdings-storage/holdings?query=';

    switch ($rectype){

    case "in":

        if($from =="uuid") {
            $r = getFolioData($qin."(id==".$id.")");
        }elseif($from =="hrid") {
            $r = getFolioData($qin."(hrid==".$id.")");
        }

        if($r["totalRecords"]==0) {
            $uuid = $hrid = "";
        }else{
            $uuid =  $r['instances'][0]["id"];
            $hrid =  $r['instances'][0]["hrid"];
        }
        break;

    case "it":
        if($from == "uuid") {
            $r = getFolioData($qit."(id==".$id.")");
        }elseif($from == "hrid") {
            $r = getFolioData($qit."(hrid==".$id.")");
        }

        if($r["totalRecords"]==0) {
            $uuid = $hrid = "";
        }else{
            $uuid =  $r["items"][0]["id"];
            $hrid =  $r["items"][0]["hrid"];
        }
        break;

    case "ho":
        if($from =="uuid") {
                $r = getFolioData($qho."(id==".$id.")");
        }elseif($from == "hrid") {
            $r = getFolioData($qho."(hrid==".$id.")");
        }

        if($r["totalRecords"]==0) {
            $uuid = $hrid=  "";
        }else{
            $uuid =  $r["holdingsRecords"][0]["id"];
            $hrid =  $r["holdingsRecords"][0]["hrid"];
        }
        break;
    } //end of SWICTH

    if($from =="uuid") {
            $id = $hrid;
    }elseif($from =="hrid") {
            $id = $uuid;
    }

        return $id;

} //end offunction idConv

/*=========================*/
FUNCTION idType($hrid)
{

    return substr($hrid, 0, 2);

}
