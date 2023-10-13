<style>
	.vmi_topbar{
		padding: 25px 0px 0px 0px;
		background: white;
	}
	.vmi_topbar .logo_topbar{
		height: 50px;
	}
	.bell_notify{
		color: #00000050;
		cursor: pointer;
	}
	button.my_tickets{
		padding: 8px 15px;
		border-radius: 15px;
		margin-left: 10px;
		font-size: 0.8rem;
		background: var(--primaria);
		border: 1px solid var(--primaria);
		color: white;
	}
	button.login_btn{
		padding: 8px 15px;
		border-radius: 15px;
		font-size: 0.8rem;
		background: transparent;
		color: #00000080;
		border: 1px solid #00000080;
	}
	.vmi_topbar .account_pp{
		width: 50px;
		height: 50px;
		border-radius: 15px;
		background-size: cover !important;
		background-position: center center !important;
		cursor: pointer;
	}
	.vmi_topbar .search_box{
		border: 1px solid #00000040;
		background: white;
		border-radius: 25px;
	}
	.vmi_topbar .div_input{
		padding: 13px 15px;
		width: 90%;
		font-size: 0.9rem !important;
	}
	.vmi_topbar .div_input::placeholder{
		color: #00000060;
	}
	.vmi_topbar .glass_search{
		margin-left: 20px;
		color: #00000080;
	}
	.topButton_row{
		background: <?php echo $config['cor_categorias']; ?>;
		color: white;
		margin-top: 25px;
		font-size: 0.8rem !important;
		font-weight: 300;
	}
	.topButton_row .topButton_item_row{
		padding: 0px;
	}
	.topButton_item{
		text-align: center;
		cursor: pointer;
		padding: 15px 20px;
		width: 100%;
		background: linear-gradient(135deg, rgba(12,33,64,1) 0%, rgba(9,26,50,1) 100%);
		transition: all 300ms;
	}
	.topButton_item:hover{
		background: #00000020;
	}
	.topButton_item svg{
		margin-right: 5px;
	}
	.boxLocation .fa-map-pin{
		font-size: 1.3rem !important;
		color: var(--primaria) !important;
	}

	.boxLocation .topTitle{
		font-size: 0.6rem !important;
		color: var(--primaria) !important;
	}

	.boxLocation .bottomTitle{
		font-size: 0.7rem !important;
		font-weight: 500;
		color: #39474F !important;
	}
	.boxLocation .dropdown-menu{
		-webkit-box-shadow: 0px 0px 40px -22px rgba(0,0,0,0.5);
		-moz-box-shadow: 0px 0px 40px -22px rgba(0,0,0,0.5);
		box-shadow: 0px 0px 40px -22px rgba(0,0,0,0.5);
		border-radius: 15px !important;
		font-size: 0.8rem !important;
		border: none !important;
		padding: 20px;
		width: 250px;
	}
	.boxLocation input.cep{
		padding: 10px;
		border-radius: 10px;
		width: 100%;
		border: 1px solid #00000040;
	}
	.boxLocation button.cep{
		padding: 10px 0px;
		text-align: center !important;
		background: var(--primaria);
		color: white;
		border-radius: 10px;
		width: 100%;
		border: none;
	}
	.account_menu{
		border: none;
		padding: 10px 0px;
		font-size: 0.8rem !important;
		border-radius: 20px;
		overflow: hidden;
		box-shadow:  6px 6px 29px #d5d5d540,
             -6px -6px 29px #ebebeb70;
	}
	.account_menu .dropdown-item:active {
		background: #00000020 !important;
	}
	.account_menu hr {
		border-color: #00000008 !important;
		color: #000000ae !important;
	}
	.centerAlign{
		position: relative;
		top: 50% !important;
		left: 50% !important;
		transform: translate3d(-25%, -50%, 0px) !important;
	}
	.account_menu svg {
		color: #9e81bf !important;
	}
</style>

<!-- icons -->

<!-- end icons -->

<div class="vmi_topbar">
	<div style="padding: 0px 25px !important;" class="container">
		<div class="row">
			<div class="col-4">
				<a href="<?php echo $config['app_local']; ?>">
					<img class="logo_topbar" src="<?php echo $config['logo_principal']; ?>">
				</a>
			</div>
			<?php if (isLoged('user_consumer') == true) { ?>
			<div style="text-align: right;" class="col-1">
				<div class="account_box align">
					<i class="fa-solid fa-bell bell_notify"></i>
				</div>
			</div>
			<div style="position: relative !important; z-index: 10 !important;" class="col-1">
				<div class="pp_box align">
					<div class="dropdown-center">
					  <button type="button" class="no_button" data-bs-toggle="dropdown" aria-expanded="false">
						<div style="background: url('<?php echo $config['app_local'] . '/assets/pp/consumer/' . $consumer['pp'] ?>');" class="account_pp"></div>
					  </button>
					  <ul class="dropdown-menu account_menu">
					    <li><a class="dropdown-item" href="<?php echo $config['app_local'] . '/c/minha-conta' ?>"><i class="fa-solid fa-user-gear fa-sm"></i>  Minha Conta</a></li>
					    <li><a class="dropdown-item" href="<?php echo $config['app_local'] . '/c/meus-ingressos' ?>"><i class="fa-regular fa-calendar-check"></i>  Meus Ingressos</a></li>
					    <li><hr class="dropdown-divider"></li>
					    <li><a class="dropdown-item" href="<?php echo $config['app_local'] . '/config/logout.php' ?>"><i class="fa-solid fa-arrow-right-from-bracket fa-sm"></i>  Sair</a></li>
					  </ul>
					</div>
				</div>
			</div>
			<?php	} else { ?>
			<div style="text-align: right; position: relative; z-index: 10;" class="col-8">
				<div class="align dropdown-center">
					<button onclick="window.location.href='<?php echo $config['app_local'] ?>/login';" class="login_btn">Login</button>
					<button data-bs-toggle="dropdown" aria-expanded="false" type="button" class="my_tickets">Cadastro</button>
					
					<div class="dropdown">
					  <ul class="dropdown-menu account_menu">
					    <li><a class="dropdown-item" href="<?php echo $config['app_local'] . '/cadastrar' ?>"><i class="fa-solid fa-user fa-sm"></i>  Usuário</a></li>
					    <li><a class="dropdown-item" href="<?php echo $config['app_local'] . '/produtor/cadastrar' ?>"><i class="fa-regular fa-calendar"></i>  Produtor</a></li>
					  </ul>
					</div>
				</div>
			</div>
			<?php } ?>
			<div style="position: relative !important; z-index: 10 !important; margin-top: 25px;" style="text-align: left;" class="col-12">
				<div class="centerAlign">
					<div class="boxLocation">
						<div class="dropdown-center">
						  <button class="no_button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="row">
								<div class="col-2">
									<i class="fa-solid fa-map-pin align"></i>
								</div>
								<div style="text-align: left !important;" class="col-10">
									<div class="align">
										<label style="cursor: pointer;" class="topTitle">Eventos próximos à</label><br>
										<label style="cursor: pointer;" class="bottomTitle dropdown-toggle">
											<?php 
												if (isset($_SESSION['location']->localidade) AND isset($_SESSION['location']->uf)) { 
													echo $_SESSION['location']->localidade . ', ' . $_SESSION['location']->uf;
												} else { 
													echo getUserLocation();
												} 
											?>
										</label>
									</div>
								</div>
							</div>
						  </button>
						  <ul class="dropdown-menu">
						  	<p>para ver os melhores fretes e prazos para sua região</p>
						  	<p>insira o seu cep:</p>
						  	<form method="POST" action="<?php echo $config['app_local'] ?>/config/actions/cep.php">
							  	<div class="row">
							  		<div style="padding: 0px 3px 0px 12px;" class="col-9">
							  			<input id="cep" maxlength="9" minlength="9" placeholder="_____-___" class="cep" type="text" name="cep" 
							  			value="<?php if(isset($_SESSION['location']->cep)) { echo $_SESSION['location']->cep; } else { if ($_SERVER['REMOTE_ADDR'] == '::1') { echo '00000-000'; } else { echo getUserCep(); } } ?>">
							  		</div>
							  		<div style="padding: 0px 12px 0px 3px;" class="col-3">
							  			<button class="cep">ok</button>
							  		</div>
							  	</div>
						  	</form>
						  </ul>
						</div>
					</div>
				</div>
			</div>
			<div style="margin-top: 20px;" class="col-12 mx-auto">
				<div class="search_box align">
					<i class="fa-solid fa-magnifying-glass fa-xs glass_search"></i>
					<input style="width: 88% !important;" class="no_input div_input" placeholder="Pesquise o seu próximo evento" type="search" name="search">
				</div>
			</div>
		</div>
	</div>
	<div style="position: relative !important; z-index: 1 !important; background: transparent !important;" class="topButton_row">
		<div class="container-fluid">
			<div class="row">
				<div style="text-align: right;" onclick="window.location.href='<?php echo $config['app_local'] . '/revender' ?>'" class="col-6 topButton_item_row mx-auto">
					<div class="align">
						<div style="background: #a695c1 !important; border: none;" class="topButton_item">
							<i class="fa-solid fa-receipt fa-sm"></i>
							<span>Revender</span>
						</div>
					</div>
				</div>
				<div style="text-align: right;" onclick="window.open('<?php echo $config['app_local'] ?>/novo-evento', '_blank');" 
					 class="col-6 topButton_item_row mx-auto">
					<div class="align">
						<div style="background: #AFA4CE !important; border: none;" class="topButton_item">
							<i class="fa-solid fa-calendar-plus fa-sm"></i>
							<span>Postar Eventos</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');

    cepInput.addEventListener('input', function(event) {
        const input = event.target;
        const value = input.value.replace(/\D/g, '');

        if (value.length > 8) {
            input.value = value.slice(0, 8);
        } else if (value.length >= 5) {
            input.value = value.slice(0, 5) + '-' + value.slice(5);
        } else {
            input.value = value;
        }
    });
});
</script>