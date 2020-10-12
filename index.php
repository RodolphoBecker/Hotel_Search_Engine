<?php include('header.php'); ?>
		<section id="slider-home">
			<div class="slider-content" style="background-image: url('img/slider-01.jpg');">
				<div class="container">
					<div class="row">
						<div class="col-12 col-lg-12 text-white main-title">
							<h1>Procura de hotéis</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="slider-content" style="background-image: url('img/slider-02.jpg');">
				<div class="container">
					<div class="row">
						<div class="col-12 col-lg-12 text-white main-title">
							<h1>Procura de hotéis</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="slider-content" style="background-image: url('img/slider-03.jpg');">
				<div class="container">
					<div class="row">
						<div class="col-12 col-lg-12 text-white main-title">
							<h1>Procura de hotéis</h1>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section id="reserves" class="">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-12 main-title">
						<h1>Reservas</h1>
					</div>
					<div class="col-12 col-lg-12">
						<form name="formulario-hotel" action="result.php" method="post" class="main-text">
							<div class="form-group">
								<select name="location" required class="form-control location">
								  <option selected disabled >Destino</option>
								  <option value="1003944">Miami</option>
								  <option value="1010106">Orlando</option>
								</select>
							</div>
							<div class="form-group">
								<select name="nights" class="form-control nights" required>
									<option selected disabled >Núm. de Noites</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
							</div>
							<input name="date" class="check-in" required type="date" placeholder="Check-in">
							<div class="form-group">
								<select name="national" class="form-control national">
									<option value="BR">Brasileiro</option>
								</select>
							</div>
							<div class="form-group">
								<select name="adult" required class="form-control adult">
									<option selected disabled >Adultos</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
							</div>
							<div class="form-group">
								<select name="children" class="form-control children">
									<option selected disabled >Idade das Crianças</option>
									<option value="0">Sem Crianças</option>
									<option value="1">1 ano</option>
									<option value="2">2 anos</option>
									<option value="3">3 anos</option>
									<option value="4">4 anos</option>
									<option value="5">5-10 anos</option>
								</select>
							</div>
							<div class="form-group">
								<select name="roomNumber" required class="form-control room-numbers">
									<option selected disabled >Quantidade de Quartos</option>
									<option value="1">1 Quarto</option>
									<option value="2">2 Quartos</option>
									<option value="3">3 Quartos</option>
									<option value="4">4 Quartos</option>
								</select>
							</div>
							<input class="submit-button" type="submit" value="Pesquisar">
						</form>
					</div>
				</div>
			</div>
		</section>
<?php include('footer.php'); ?>