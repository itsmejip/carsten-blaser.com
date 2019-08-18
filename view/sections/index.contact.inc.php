<?php use Jip\Library\Recaptcha; $recaptcha = new Recaptcha(DATA_FILE_RECAPTCHA); ?>
<div class="section contact pp-scrollable">
	<div class="container contact-container">
		<div class="row">
			<div class="col-lg-12">
				<div class="row socialmedia-links">
					<div class="col-4 text-center">
						<a href="https://www.linkedin.com/in/carsten-blaser-23a4a0141" target="_blank" rel="noreferrer">
							<i class="fab fa-linkedin fa-5x" title="LinkedIn"></i>
						</a>
					</div>
					<div class="col-4 text-center">
						<a href="https://www.twitter.com/___jip" target="_blank" rel="noreferrer">
							<i class="fab fa-twitter-square fa-5x" title="Twitter"></i>
						</a>
					</div>
					<div class="col-4 text-center">
						<a href="https://www.twitch.tv/wtfjip" target="_blank" rel="noreferrer">
							<i class="fab fa-twitch fa-5x" title="Twitch"></i>
						</a>
					</div>
				</div>
				<form id="contact-form" class="needs-validation" method="post" action="/#contact" novalidate>
					<div class="send-response <?= (isset($_SESSION["SEND_CONTACT_FORM_SUCCESS"]) ? "active" : ""); ?>">
						<?php if (isset($_SESSION["SEND_CONTACT_FORM_SUCCESS"])): ?>
							<?php if ($_SESSION["SEND_CONTACT_FORM_SUCCESS"]["done"]): ?>
								<span class="success">
									<i class="far fa-5x fa-check-circle"></i>
								</span>
							<?php else: ?>
								<span class="error">
									<i class="fas fa-5x fa-exclamation-triangle"></i>
								</span>
							<?php endif; ?>
							<?php unset($_SESSION["SEND_CONTACT_FORM_SUCCESS"]);?>
						<?php endif; ?>
					</div>
					<div class="form-row">
						<div class="form-group col-sm-2">
							<select name="salutation" class="form-control form-control-lg" required>
								<option value="mr" <?= $_POST["salutation"] == "mr" ? "selcted" : "" ?>><@trans.sal_mr@></option>
								<option value="mrs" <?= $_POST["salutation"] == "mrs" ? "selcted" : "" ?>><@trans.sal_mrs@></option>
								<option value="x" <?= $_POST["salutation"] == "x" ? "selcted" : "" ?>><@trans.sal_x@></option>
							</select>
						</div>
						<div class="form-group col-sm-10">
							<input type="text" class="form-control form-control-lg" id="contact-form-name" name="name" placeholder="<@trans.name@> *" value="<?= $_POST["name"] ?>" required>
						</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control form-control-lg" id="contact-form-company" name="company" placeholder="<@trans.company@>" value="<?= $_POST["company"] ?>">
					</div>
					<div class="form-group">
						<input type="text" class="form-control form-control-lg" id="contact-form-email" name="email" placeholder="<@trans.email@> *" value="<?= $_POST["email"] ?>" required>
					
					</div>
					<div class="form-group">
						<textarea name="message" class="form-control form-control-lg" placeholder="<@trans.message@> *" style="height:200px" required><?= $_POST["message"] ?></textarea>
					</div>
					<div class="g-recaptcha-container">
						<div class="g-recaptcha" data-sitekey="<?php echo  $recaptcha->getSiteKey();?>"></div>
						<label id="recaptcha-error" style="display:none"><@trans.errorRecaptcha@></label>
					</div>
					<div class="row info">
						<div class="col-lg-8 send-info help-block">
						<@trans.info@>
						</div>
						<div class="col-lg-4 send-button text-right">
							<button type="submit" class="btn btn-primary btn-lg"><@trans.sendMessage@></button>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var CONTACT_FORM_MESSAGE_NAME = "<@trans.errorName@>"
		var CONTACT_FORM_MESSAGE_EMAIL = "<@trans.errorEmail@>"
		var CONTACT_FORM_MESSAGE_MESSAGE = "<@trans.errorMessage@>"
	</script>
</div>

