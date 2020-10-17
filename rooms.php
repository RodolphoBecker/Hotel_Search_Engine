<?php
	include("api.php");

	// Carreguei a função de comunicação com a API
	$api_com = new api_comunicacao;

	// Criei um array com os dados que utilizei, retornados da API e armazenei em uma variavel para realizar as verificações
	$listHotels = array(
			array("name", "image", "category", "chainName", "chainName", "cityNamePT", "address", "website", "latitude", "longitude", "numberRooms", "averageValue")
		);

	// Verificação de preenchimento dos campos do formulário da home
	isset($_POST["location"]) ? $location = $_POST["location"] : $location = "";
	isset($_POST["nights"]) ? $nights = $_POST["nights"] : $nights = "";
	isset($_POST["date"]) ? $date = $_POST["date"] : $date = "";
	isset($_POST["national"]) ? $national = $_POST["national"] : $national = "BR";
	isset($_POST["adult"]) ? $adult = $_POST["adult"] : $adult = "";
	isset($_POST["children"]) ? $children = $_POST["children"] : $children = 0;
	isset($_POST["roomNumber"]) ? $roomNumber = $_POST["roomNumber"] : $roomNumber = 1;

	$resultHtml = "";

	// Se os dados de localização, numero de noites, data e numero de adultos não forem preenchidos ele retorna para a home, senão ele mostra os dados buscados na API
	if ( ( $location == "" ) || ( $nights == "" ) || ( $date == "" ) || ( $adult == "" ) ) {
		echo "ERRO";
	} else {
		// Criação de diversas váriaveis e armazenado nelas as credenciais e critérios da API para facilitar as inserções
		$header = array("Host: pp.cangooroo.net", "Content-Type: application/json", "Accept: application/json");
		$url = "https://pp.cangooroo.net";
		$resource = "/ws/rest/hotel.svc/Search";
		$method = "POST";
		$user = "usuario";
		$pass = "senha";
		$content = '{
				"Credential": {
					"Username": "' . $user . '",
					"Password": "' . $pass . '"
				},
				"Criteria": {
					"DestinationId": "' . $location . '",
					"NumNights": "' . $nights . '",
					"CheckinDate": "' . $date . '",
					"MainPaxCountryCodeNationality": "' . $national . '",
					"SearchRooms": [{
						"NumAdults": "' . $adult . '",';
						if ( $children > 0 ) $content .= '"ChildAges": [' . $children . '],';
						$content .= '"Quantity": ' . $roomNumber . '
					}]
				}
			}';

		//Armazenamento em uma variavel os resultados da busca na API com os parametros armazenados nas váriaveis do passo anterior
		$result = $api_com->enviar($header, $content, $url . $resource,  $method);

		//Transformação do resultado da busca que é um json em um array de dados
		$resultJson = json_decode($result, true);

		//Verificação da localidade escolhida, e abertura do seu respectivo arquivo json para futuras pesquisas
		if ( $location == "1010106" ) {
			$orlando = fopen("hotels-orlando.json", "r");
			$hotelList = fread($orlando, filesize("hotels-orlando.json"));
			fclose($orlando);
		} else {
			$miami = fopen("hotels-miami.json", "r");
			$hotelList = fread($miami, filesize("hotels-miami.json"));
			fclose($miami);
		}
		$hotelListJson = json_decode($hotelList, true);
		
		//Foi setado um limite máximo para retorno da busca na API para 10 hotéis pois o tempo de busca está muito longo para todos os hotéis, necessitando uma paginação e talvez um Ajax mais bem elaborado
		$limit = count($resultJson["Hotels"]);
		$limit = 10;

		//Estrutura da repetição para a mostra dos hotéis em relação aos dados preenchidos no formulário
		for ( $i = 0; $i < $limit; $i++ ) {
			for ( $j = 0; $j < count($hotelListJson); $j++ ) {
				if ( $hotelListJson[$j]['id'] == $resultJson["Hotels"][$i]["HotelId"] ) {
					$numberRooms = 0;
					$totalValue = 0;
					$averageValue = 0;
					switch ( intval($hotelListJson[$i]["category"]) ) {
						case 1:
							$category = "Baixo Padrão";
						break;
						case 2:
							$category = "Padrão";
						break;
						case 3:
							$category = "Luxo";
						break;
						case 4:
							$category = "Super Luxo";
						break;
						case 5:
							$category = "Premium";
						break;
						default:
							$category = "Indefinida";
						break;
					}

					$limitRooms = count($resultJson["Hotels"][$i]["Rooms"]);
					for ( $k = 0; $k < $limitRooms; $k++ ) {
						if ( $resultJson["Hotels"][$i]["Rooms"][$k]["IsAvailable"] ) {
							$numberRooms++;
							$totalValue+= floatval($resultJson["Hotels"][$i]["Rooms"][$k]["TotalSellingPrice"]["Value"]);
						}
					}
					$averageValue = round($totalValue / $numberRooms, 2);

					$resultHtml.= "<div class='result-single w-100 d-flex flex-wrap'>
						<div class='image col-12 col-lg-6'>
							<div style='background-image: url(" . $hotelListJson[$i]["urlThumb"] .");'></div>
							<div style='background-image: url(img/image-placeholder.png);'></div>
						</div>
						<div class='content col-12 col-lg-6'>
							<div class='title main-title'>
								<h1>" . $hotelListJson[$i]["name"] . "</h1>
							</div>
							<div class='subtitle main-title'>
								<h2>" . $category . "</h2>
							</div>
							<div class='excerpt main-text hover-padrao'>
								<p>" . $hotelListJson[$i]["chainName"] . "<br>" 
								. $hotelListJson[$i]["cityNamePT"] . "<br>" 
								. $hotelListJson[$i]["address"] . "<br>
								</p>
								<a href='" . $hotelListJson[$i]["website"] . "' target='blank'>Ir para o site do hotel</a>
								<a href='https://www.google.com/maps/?q=" . $hotelListJson[$i]["latitude"] . "," . $hotelListJson[$i]["longitude"] . "' target='blank'>Ver no mapa</a>
							</div>
						</div>
						<div class='services col-12 col-lg-12'>
							<div>
								<ul>
									<li class='main-text'>
										<img class='img-fluid' src='img/icon-wifi.svg' alt=''>
										<p>Wi-fi</p>
									</li>
									<li class='main-text'>
										<img class='img-fluid' src='img/icon-coffee.svg' alt=''>
										<p>Café da Manhã</p>
									</li>
									<li class='main-text'>
										<img class='img-fluid' src='img/icon-bar.svg' alt=''>
										<p>Bar</p>
									</li>
									<li class='main-text'>
										<img class='img-fluid' src='img/icon-restaurant.svg' alt=''>
										<p>Restaurante</p>
									</li>
									<li class='main-text'>
										<img class='img-fluid' src='img/icon-air.svg' alt=''>
										<p>Ar Condicionado</p>
									</li>
								</ul>
							</div>
						</div>
						<div class='prices col-12 col-lg-12'>
							<div>
								<div class='titulo main-title text-white'>
									<h1>Quartos disponíveis e valores:</h1>
								</div>
								<ul>
									<li class='main-text text-white'>
										<p>Quartos disponíveis: " . $numberRooms . "</p>
									</li>
									<li class='main-text text-white'>
										<p>Média de valores dos quartos: $ " . number_format($averageValue, 2, ".", "") . "</p>
									</li>
									<li class='main-text text-white'>
										<p>Valor estimado diário para $roomNumber quartos é de $ " . number_format(($averageValue / $roomNumber), 2, ".", "") . " por quarto.</p>
									</li>
									<li class='main-text text-white'>
										<p>Valor estimado total para $roomNumber quartos durante uma estadia de $nights noites é de: $ " . number_format(($averageValue * $roomNumber * $nights), 2, ".", "") . " </p>
									</li>
								</ul>
							</div>
						</div>
					</div>";

					$listHotels[$i]["name"] = $hotelListJson[$i]["name"];
					$listHotels[$i]["image"] = $hotelListJson[$i]["urlThumb"];
					$listHotels[$i]["category"] = $hotelListJson[$i]["category"];
					$listHotels[$i]["chainName"] = $hotelListJson[$i]["chainName"];
					$listHotels[$i]["chainName"] = $hotelListJson[$i]["chainName"];
					$listHotels[$i]["cityNamePT"] = $hotelListJson[$i]["cityNamePT"];
					$listHotels[$i]["address"] = $hotelListJson[$i]["address"];
					$listHotels[$i]["website"] = $hotelListJson[$i]["website"];
					$listHotels[$i]["latitude"] = $hotelListJson[$i]["latitude"];
					$listHotels[$i]["longitude"] = $hotelListJson[$i]["longitude"];
					$listHotels[$i]["numberRooms"] = $numberRooms;
					$listHotels[$i]["averageValue"] = $averageValue;
				}
			}
		}
		echo $resultHtml;
	}
?>