<?php 

use Jip\Library\Session;

    global $path;
    global $lang;

    $presenter = new Jip\Presenter\HeaderPresenter($path, $lang, Session::get()->getCsrfToken()->getToken());
	$presenter->showView();
?>
<div class="section">
	<div class="container impressum-container">
		<div class="row">
			<div class="col-xs-12">
				<h2><@trans.title@></h2>
				<h4><?= $_SERVER["SERVER_NAME"] ?></h4>
				<p>&nbsp;</p>
				<p>	
					<strong><@trans.address@></strong><br />
					Carsten Blaser<br/>
					Gärtnerstraße 53<br />
					66117 Saarbrücken
				</p>
				<p style="margin-top:20px">
					<strong><@trans.legals.cont.rep@></strong><br />
					Carsten Blaser
				</p>
				<p>
					<strong><@trans.cont.title@></strong><br/>
					<@trans.cont.text@>
				</p>
			</div>
		</div>
	</div>
</div>