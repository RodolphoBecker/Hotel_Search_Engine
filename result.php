<?php
	// Verificação de preenchimento dos campos do formulário da home
	isset($_POST["location"]) ? $location = $_POST["location"] : $location = "";
	isset($_POST["nights"]) ? $nights = $_POST["nights"] : $nights = "";
	isset($_POST["date"]) ? $date = $_POST["date"] : $date = "";
	isset($_POST["national"]) ? $national = $_POST["national"] : $national = "BR";
	isset($_POST["adult"]) ? $adult = $_POST["adult"] : $adult = "";
	isset($_POST["children"]) ? $children = $_POST["children"] : $children = 0;
	isset($_POST["roomNumber"]) ? $roomNumber = $_POST["roomNumber"] : $roomNumber = 1;

	// Se os dados de localização, numero de noites, data e numero de adultos não forem preenchidos ele retorna para a home, senão ele mostra os dados buscados na API
	if ( ( $location == "" ) || ( $nights == "" ) || ( $date == "" ) || ( $adult == "" ) ) {
		header("Location: .");
	} else {
		$script = "loadRooms(" . $location . ", " . $nights . ", '" . $date . "', '" . $national . "', " . $adult . ", " . $children . ", " . $roomNumber . ");";
	}
?>
<?php include('header.php'); ?>
		<div class="image-cape" style="background-image: url('img/image-hotel-01.jpg');">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12 main-title text-white">
						<h1>Resultados</h1>
					</div>
				</div>
			</div>
		</div>
		<section id="results">
			<div id="loader-screen">
				<div class="circle">
					<div class="wave"></div>
				</div>
			</div>
			<div class="container">
				<div id='list' class="row"></div>
			</div>
		</section>
		<script type="text/javascript"><?php echo $script; ?></script>
<?php include('footer.php'); ?>