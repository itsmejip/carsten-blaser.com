function initContactForm() {
    $("#contact-form").validate({
		rules: {
            name: "required",
            email: {
				required: true,
				email: true
            },
			message: "required",
		},	
		messages: {
			name:CONTACT_FORM_MESSAGE_NAME,
            email:CONTACT_FORM_MESSAGE_EMAIL,
			message:CONTACT_FORM_MESSAGE_MESSAGE,
		}, 
		submitHandler: function (form) {
			var response = grecaptcha.getResponse();
			console.log(response.length);
			if (response.length == 0) {
			   $('#recaptcha-error').css("display", "inline-block");
			   return false;
			} else {
				$('#recaptcha-error').css("display", "none");
			   pageDirty = false;
			   return true;
			}
		}
	});
}