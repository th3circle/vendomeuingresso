<style>
	:root {
		--primaria: #1400FF !important;
		--secundaria: #0F00BB !important;
	}
	body {
		padding: 100px 50px 50px calc(250px + 50px) !important;
	}
	div.leftbar {
		box-shadow: 15px 0px 54px -5px #00000010;
		background: var(--secundaria);
		position: fixed;
		height: 100vh;
		z-index: 10;
		width: 250px;
		left: 0;
		top: 0;
	}
	.leftbarContent {
		padding: 50px 35px;
		font-weight: 300;
		color: white;
	}
	.leftbar_logo {
		width: 80%;
		cursor: pointer;
		margin-bottom: 25px;
	}
	.left_links {
		width: 100%;
		padding: 20px;
		background: #00000015;
		border-radius: 20px;
		cursor: pointer;
		transition: all 300ms;
		margin-bottom: 13px;
	}
	.left_links:hover {
		background: #00000025;
	}
	.left_links .leftIcon{
		text-align: center;
		padding-right: 0px;
	}
	.linkText {
		list-style-type: none;
	}
	.active_leftLink {
		background: #00000040 !important;
	}
	.divider {
		padding: 0px 0px;
	}
	.divider hr {
		border-color: #FFFFFF50 !important;
	}
	.account_box {
		padding: 10px;
		background: #00000020;
		border-radius: 20px;
		box-shadow: inset 0px 0px 45px 0px #00000020;
	    background: rgba( 255, 255, 255, 0.35 );
	    backdrop-filter: blur( 13.5px );
	    -webkit-backdrop-filter: blur( 13.5px );
		cursor: pointer;
	}
	.leftbar_pp {
		width: 100%;
		padding-bottom: 100%;
		border-radius: 15px;
		background-size: cover !important;
		background-position: center center !important;
	}
	.account_box .rightBox {
		padding-left: 5px;
		color: #faf0ff;
	}
	.account_box .btm_name {
		color: #faf0ff80;
		font-size: 0.55rem;
	}
	.account_box label {
		cursor: pointer;
	}
	.left_links .rightText {
		padding-left: 7px !important;
		font-weight: 300 !important;
		font-size: 0.75rem !important;
	}
	.logout{
		position: fixed;
		left: 0;
		bottom: 0;
		padding: 15px;
		background: #00000015;
		text-align: center;
		color: #FFFFFFe3;
		font-size: 0.7rem !important;
		cursor: pointer;
		width: 250px;
	}
	.producer_pp {
		width: 100%;
		padding-bottom: 100%;
		border-radius: 15px;
		background-size: cover !important;
		background-position: center center !important;
	}
	.account .account_name {
		font-size: 0.8rem !important;
	}
	.account .account_surname {
		font-size: 0.6rem !important;
		color: #c9c9c9;
	}
	div.account {
		background: #00000020;
		cursor: pointer;
		padding: 10px;
		border-radius: 20px;
	}
	.account label {
		cursor: pointer;
	}
	.alert p {
		font-size: 0.6rem !important;
		color: white;
		margin-bottom: 0px;
	}
	.alert a {
		text-decoration: none;
	}
	.alert {
		background: #00000030;
		border-radius: 20px;
		padding: 13px 15px;
	}
	.divider hr {
		margin: 10px 0px;
	}
</style>

<div class="leftbar">
	<div class="leftbarContent">
		<div class="row">
			<div class="col-12" style="text-align: center;">
				<img onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/eventos'" class="leftbar_logo" src="<?php echo $config['logo_admin']; ?>">
			</div>
			<div class="col-12">
				<div class="divider">
					<hr style="border-color: transparent !important;">
					<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/minha-conta'" class="account <?php if ($page_name == 'Minha Conta') { echo 'active_leftLink'; } ?>">
						<div class="row">
							<div style="padding-right: 3px;" class="col-4">
								<div style="background: url('<?php echo $config['app_local'] ?>/assets/pp/superadmin/<?php if (empty($superadmin['pp'])) { echo 'no-picture.jpg'; } else { echo $superadmin['pp']; } ?>');" class="producer_pp"></div>
							</div>
							<div class="col-sm">
								<div class="align">
									<label class="account_name"><?php echo $superadmin['nome']; ?></label><br>
									<label class="account_surname"><?php echo $superadmin['usuario']; ?></label>
								</div>
							</div>
						</div>
					</div>
					<hr style="border-color: transparent !important;">
				</div>
			</div>
			<div class="col-12">

				<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/eventos'" 
					class="left_links <?php if ($page_name == 'Eventos') { echo 'active_leftLink'; } ?>">
					<div class="row">
						<div class="col-3 leftIcon">
							<div class="align">
								<i class="fa-regular fa-sm fa-calendar-days"></i>
							</div>
						</div>		
						<div class="col-sm rightText">
							<li class="linkText align">Eventos</li>
						</div>
					</div>
				</div>

				<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/produtores'" 
					class="left_links <?php if ($page_name == 'Produtores') { echo 'active_leftLink'; } ?>">
					<div class="row">
						<div class="col-3 leftIcon">
							<div class="align">
								<i class="fa-solid fa-user-group fa-xs"></i>
							</div>
						</div>		
						<div class="col-sm rightText">
							<li class="linkText align">Produtores</li>
						</div>
					</div>
				</div>

				<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/financeiro'" 
					class="left_links <?php if ($page_name == 'Financeiro') { echo 'active_leftLink'; } ?>">
					<div class="row">
						<div class="col-3 leftIcon">
							<div class="align">
								<i class="fa-solid fa-wallet fa-xs"></i>
							</div>
						</div>		
						<div class="col-sm rightText">
							<li class="linkText align">Financeiro</li>
						</div>
					</div>
				</div>

				<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/preferencias'" 
					class="left_links <?php if ($page_name == 'Preferências') { echo 'active_leftLink'; } ?>">
					<div class="row">
						<div class="col-3 leftIcon">
							<div class="align">
								<i class="fa-solid fa-sm fa-gear"></i>
							</div>
						</div>		
						<div class="col-sm rightText">
							<li class="linkText align">Preferências</li>
						</div>
					</div>
				</div>

				<div onclick="window.location.href='<?php echo $config['app_local'] ?>/superadmin/app/logout.php'" class="logout">
					<div class="row">
						<div class="col-12">
							Sair
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<style>
	div.topbar{
		position: fixed;
		font-size: 0.8rem;
		z-index: 1;
		width: 100%;
		left: 0;
		top: 0;
		padding: 25px 50px 25px 300px;
		background: white !important;
		box-shadow:  5px 5px 10px #f5f5f5,
             -5px -5px 10px #ffffff;
	}
	.topbar_right{
		text-align: right;
	}
	.topbar_right svg{
		cursor: pointer;
		color: #00000050;
		font-size: 1rem;
	}
	.topbar_left{
		color: #00000070;
	}
	.dotright{
		margin: 0px 10px;
	}
	.topbar_left .fa-folder{
		cursor: pointer;
	}
</style>

<div class="topbar">
	<div class="container">
		<div class="row">
			<div class="col-6 topbar_left">
				<div class="align">
					<label>
						<i onclick="window.location.href='<?php echo $config['app_local'] ?>/painel';" class="fa-regular fa-folder"></i>
						<label class="dotright">></label>
						<?php echo $page_name ?>
					</label>
				</div>
			</div>
			<div class="col-6 topbar_right">
				<div class="align">
					<i class="fa-regular fa-bell"></i>
				</div>
			</div>
		</div>
	</div>
</div>