// $rachow - BOOM: intTel init this .!
$(function(){
	// load'em the country resides ..!
	var inputTel = document.querySelector('input[type="tel"]');
	var inTelInit = window.intlTelInput(inputTel, {
		initialCountry: "GB",
		geoIpLookup: function(_call){
			$.get('https://ipinfo.io', function(){}, "jsonp").always(function(resp){
				var countryCode  = (resp && resp.country) ? resp.country : "";
				console.log("Boombastic locale: " + countryCode);
				_call(countryCode);
			});
		},
		autoPlaceholder: "off",
		separateDialCode: true,
		utilsScript: "/assets/dist/vendor/js/utils.js?1743234336313" /* $rachow - cache burst here buddy :D */
	});

	var inputTelErr = document.querySelector("#input-tel-err");
	var inputTelOK  = document.querySelector("#input-tel-ok");

	var errMapper = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

	var reset = function(){
		inputTel.classList.remove("error");
		inputTelErr.innerHTML = "";
		inputTelErr.classList.add("hide");
		inputTelOK.classList.add("hide");
	};

	inputTel.addEventListener('blur', function() {
  		reset();
  		if (inputTel.value.trim()) {
    			if (inTelInit.isValidNumber()) {
      				inputTelOK.classList.remove("hide");
    			} else {
      				inputTel.classList.add("error");
      				var errorCode = inTelInit.getValidationError();
      				inputTelErr.innerHTML = errMapper[errorCode];
      				inputTelErr.classList.remove("hide");
    			}
  		}
	});

	inputTel.addEventListener('change', reset);
	inputTel.addEventListener('keyup', reset);
});

