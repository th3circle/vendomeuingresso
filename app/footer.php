<style>
	div.footer {
		padding: 50px;
		background: #fff;
	}
	.footer_logo {
		width: 100px;
	}
	.desc_business {
		font-size: 0.7rem !important;
		margin-top: 20px;
		font-weight: 300;
		color: #00000090;
	}
	.social_icons svg {
		height: 15px;
		width: 15px;
		padding: 8px;
		cursor: pointer;
		margin-right: 5px;
		border-radius: 100%;
		color: white;
		background: var(--secundaria);
	}
	.title_footer {
		font-size: 1.1rem !important;
		font-weight: 500;
		color: #000000ae;
		margin-bottom: 15px;
	}
	.menu_footer {
		font-size: 0.8rem !important;
		list-style: none;
		padding-left: 0px;
	}
	.menu_footer li {
		margin-bottom: 3px;
		cursor: pointer;
	}
	img.getItOn {
		width: 130px;
		margin-bottom: 5px;
		cursor: pointer;
	}
	.footer_copy {
		font-size: 0.5rem !important;
		font-weight: 300 !important;
		margin-bottom: 0px;
		color: #FFFFFF;
	}
	div.copyright {
		background: var(--secundaria);
		padding: 4px 0px;
	}
	div.newslatter {
		padding: 30px;
		background: var(--primaria);
		margin-top: 150px;
	}
	.newslatter input {
		padding: 15px 25px !important;
		font-size: 0.8rem !important;
		border-radius: 20px;
	}
	button.newslatter_send {
		width: 100%;
		padding: 20px 0px;
		color: white;
		font-size: 0.8rem !important;
		background: #00000020;
		border-radius: 20px;
		border: none;
	}
	.input_footer {
		font-size: 0.7rem !important;
		font-weight: 300 !important;
		margin-left: 25px;
		color: white;
	}
	.alert_terms {
		margin-bottom: 0px;
		font-size: 0.6rem !important;
		color: #FFFFFF50;
/*		margin-left: 20px;*/
		font-weight: 300;
	}
	h2.title_newslatter {
		color: white;
		font-size: 2.5rem;
	}
	p.desc_newslatter {
		font-weight: 300;
		font-size: 0.9rem !important;
		color: #FFFFFF99;
	}
</style>

<?php 

	// insert into > newslatter
	if (isset($_POST['newslatter'])) {

		$email 	= $_POST['newslatter_email'];
		$ip 	= $_SERVER['REMOTE_ADDR']; 

		if ($ip == '::1') {

			$cidade = 'Localhost';
			$estado = 'Localhost';

		} else {

			$ipDetails = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
			
			$cidade = $ipDetails->city;
			$estado = $ipDetails->region;

		}

        $query = "INSERT INTO newslatter (email, cidade, estado) VALUES ('$email', '$cidade', '$estado')";
        $conn->query($query);

	}

?>

<div class="newslatter">
	<div class="container">
		<div class="row">
			<div class="col-7">
				<h2 class="title_newslatter">Assine nossa Newslatter</h2>
				<p class="desc_newslatter">Receba em primeira mão todas as nossas novidades, ofertas e atualizações!</p>
			</div>
			<div class="col-sm">
				<div class="align">
					<form method="POST" action="" id="newslatter">
						<div class="row">
							<div class="col-10">
								<!-- <label class="input_footer">E-mail: </label> -->
								<input type="email" placeholder="O seu melhor e-mail" name="newslatter_email">
							</div>
							<div class="col-2">
								<!-- <label class="input_footer">ㅤ</label> -->
								<button form="newslatter" class="newslatter_send" name="newslatter">
									<i class="fa-solid fa-paper-plane"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-3">
				<a href="<?php echo $config['app_local'] ?>"><img class="footer_logo" src="<?php echo $config['logo_principal'] ?>"></a>
				<p style="width: 80%;" class="desc_business">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua.
				consequat.</p>
				<div style="margin-top: 25px;" class="social_icons">
					<?php 
					if (isset($config['instagram']) AND !empty($config['instagram'])) { echo '<a target="_blank" href="'.$config['instagram'].'"><i class="fa-brands fa-instagram"></i></a>'; }
					if (isset($config['facebook']) AND !empty($config['facebook'])) { echo '<a target="_blank" href="'.$config['facebook'].'"><i class="fa-brands fa-facebook-f"></i></a>'; }
					if (isset($config['twitter']) AND !empty($config['twitter'])) { echo '<a target="_blank" href="'.$config['twitter'].'"><i class="fa-brands fa-x-twitter"></i></a>'; }
					if (isset($config['linkedin']) AND !empty($config['linkedin'])) { echo '<a target="_blank" href="'.$config['linkedin'].'"><i class="fa-brands fa-linkedin-in"></i></a>'; }
					if (isset($config['whatsapp']) AND !empty($config['whatsapp'])) { echo '<a target="_blank" href="'.$config['whatsapp'].'"><i class="fa-brands fa-whatsapp"></i></a>'; }
					?>
				</div>
			</div>
			<div class="col-2">
				<h4 class="title_footer">Menu</h4>
				<ul class="menu_footer">
					<li onclick="window.location.href='<?php echo $config['app_local'] ?>/'">Home</li>
					<li onclick="window.location.href='<?php echo $config['app_local'] ?>/eventos'">Comprar</li>
					<li onclick="window.location.href='<?php echo $config['app_local'] ?>/revender'">Revender</li>
					<li onclick="window.location.href='<?php echo $config['app_local'] ?>/novo-evento'">Postar Evento</li>
				</ul>
			</div>
			<div class="col-2">
				<h4 class="title_footer">Ajuda</h4>
				<ul class="menu_footer">
					<li>LGPD</li>
					<li>Ética e conduta</li>
					<li>Políticas de privacidade</li>
					<li>Fale Conosco</li>
				</ul>
			</div>
			<div class="col-2">
				<h4 class="title_footer">Categorias</h4>
				<ul class="menu_footer">
					<?php // [Lancelot]: faz a listagem das 5 categorias mais usadas
					$consulta = "SELECT c.id, c.nome, COUNT(e.id) AS total_eventos
					             FROM categories c
					             LEFT JOIN events e ON c.id = e.categoria
					             WHERE c.status = 1
					             GROUP BY c.id, c.nome
					             ORDER BY total_eventos DESC
					             LIMIT 5";
					$con = $conn->query($consulta) or die($conn->error);
					while($dado = $con->fetch_array()) { ?>
					<li onclick="window.location.href='<?php echo $config['app_local'] . '/categoria?id=' . $dado['id']; ?>'"><?php echo $dado['nome'] ?></li>
					<?php } ?>
				</ul>
			</div>
			<div style="text-align: right;" class="col-sm">
				<h4 class="title_footer">Baixe nosso App</h4>
				<a target="_blank" href="<?php echo $config['appAndroid'] ?>"><img class="getItOn" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/2560px-Google_Play_Store_badge_EN.svg.png"><br></a>
				<a target="_blank" href="<?php echo $config['appIOS'] ?>"><img class="getItOn" src="https://www.wichitaurology.com/wp-content/uploads/2019/04/Get-it-on-apple-store.png"><br></a>
				<img style="width: 50%; margin-top: 30px;" src="https://i.ibb.co/6ZZzYDj/card.png">
			</div>
		</div>
	</div>
</div>
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col-6">
				<p class="footer_copy"><?php echo $config['app_cnpj'] . ' - ' . $config['app_razaosocial'] ?> © Todos os direitos reservados <?php echo date('Y'); ?>.</p>
			</div>
			<div style="text-align: right;" class="col-6">
				<p style="color: #ffffff;" class="footer_copy">Desenvolvido com muito ☕ por <a style="color: #ffffff; text-decoration: none;" target="_blank" href="https://thecircle.com.br">The Circle</a>.</p>
			</div>
		</div>
	</div>
</div>