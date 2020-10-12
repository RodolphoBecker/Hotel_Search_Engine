<?php 

    include "api.php";

    // Configuração da comunicação com a API ClickSign para criar o documento a ser assinado
    $api_com = new api_comunicacao;
    $cabecalho = array("Host: pp.cangooroo.net", "Content-Type: application/json", "Accept: application/json");
    $url = "https://pp.cangooroo.net";
    $recurso = "/ws/rest/hotel.svc/Search";
    $tip_req = "POST";
    $usuario = "**candidato_t4w**";
    $senha = "**candit@!2019**";
    $conteudo = '{
        "Credential": {
            "Username": "' . $usuario . '",
            "Password": "' . $senha . '"
        },
        "Criteria": {
            "DestinationId": 1010106,
            "NumNights": 2,
            "CheckinDate": "2019-01-10",
            "MainPaxCountryCodeNationality": "BR",
            "SearchRooms": [{
                "NumAdults": 1,
                "ChildAges": [5],
                "Quantity": 1
            }]
        }
    }';
    $resposta = $api_com->enviar($cabecalho, $conteudo, $url . $recurso,  $tip_req);

    // Decodifica a resposta e busca a chave do documento criado
    /*$resposta_json = json_decode($resposta, true);

    if ( array_key_exists("document", $resposta_json) ) {
        if ( array_key_exists("key", $resposta_json['document']) ) {
            $document_key = $resposta_json['document']['key'];
        }
    } */

    var_dump($resposta);

?>

