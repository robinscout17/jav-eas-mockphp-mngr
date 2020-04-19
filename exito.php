<?php
header ('Content-Tipe: application/json');
$response = array();
$body = json_decode(file_get_contents("php://input"),true);
//$response["existe"] = 123;
/*$fp = fopen("fichero.txt", "w");
fputs($fp, "--->".var_export($body,true));
fclose($fp);.
*/
$response["categoryId"  ] = $body['categoryId'  ];
$response["personId"    ] = $body['personId'    ];
$response["providerId"  ] = 2;
$response["quotationId" ] = 0;
$response["requestId"   ] = $body['requestQuotationId'];
$response["categoryDescription"]     =$body['categoryDescription'];
$response["providerBusinessName"]     ="EXITO";

//Detalles de la cotización
$arreglo = $body["details"] ;
$sumaTotal = 0;
for($i=0;$i<count($arreglo);$i++){
    $otro       = $arreglo["$i"];
    $valor      = rand(750000, 1500000);
    $sumaTotal += ( $otro['quantity'] *  $valor );
    $tema2[$i]  =array( productId => $otro['productId'],
    productDescription => $otro['categoryDescription'],   
                            quantity => $otro['quantity'],
                            amount =>  $otro['quantity'] *  $valor  ,
                            discount => 0,
                            description => 'El mejor precio',
    );
}

$response["amountTotal" ] = $sumaTotal;
$response["details"     ] = $tema2;
//API Url
$url = 'http://localhost:7073/quotation';

//Initiate cURL.
$ch = curl_init($url);


$jsonData = $response;
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

//Execute the request
$result = curl_exec($ch);
?>