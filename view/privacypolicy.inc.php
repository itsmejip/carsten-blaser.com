<?php 

use Jip\Library\Session;

    global $path;
    global $lang;

    $presenter = new Jip\Presenter\HeaderPresenter($path, $lang, Session::get()->getCsrfToken()->getToken());
	$presenter->showView();
?>
<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2><@trans.title@></h2>
				<h4><?= $_SERVER["SERVER_NAME"] ?></h4>
				<p>&nbsp;</p>
				<div class="article">
					<?php INCLUDE_ONCE LANG_PATH . "$lang/docs/privacypolicy.html"; ?>
				</div>
		</div>
	</div>
</div>