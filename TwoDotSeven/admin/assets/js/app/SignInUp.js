
$(function() {	

	var Blur = function afBlur() {
		$(".BG-Secondary").fadeIn(900);
	}
	var UnBlur = function afunBlur() {
		//$(".Bg-Gen-Hack").fadeOut(400);
	}

	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F1, #Mode4F1, #Mode5F1, #Mode5F2")
		.focus(Blur);
	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F1, #Mode4F1, #Mode5F1, #Mode5F2")
		.blur(UnBlur);
	$("#MoodBlur").mousemove(Blur);


	/**
	 * Toggles/Methods for the Sign Up Page.
	 * @author Prahant Sinha
	 */
	// Toggles
	var Toggle2F1 = 0;
	var Toggle2F2 = 0;
	var Toggle2F3 = 0;
	var Toggle2F4 = 0;
	var Process2 = 0;

	// Events handeled.
	$("#Mode2F1").change(function() {
		$.ajax({
			type: 'POST',
			url: '/dev/redundant/username',
			timeout: 30000,
			data: {
				  UserName: $("#Mode2F1").val()
			},
			beforeSend: function(){
				TintPage("BLUE");
				$("#Mode2F1fa").removeClass("fa-ellipsis-h");
				$("#Mode2F1fa").addClass("fa-spinner fa-spin-faster");
				$("#Mode2F1fa").css("color", "teal");
			},
			statusCode: {
				253: function() {
					// Success. Available username.
					TintPage("GREEN");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster fa-exclamation-triangle");
					$("#Mode2F1fa").addClass("fa-check-circle");
					$("#Mode2F1fa").css("color", "teal");
					Toggle2F1 = 1;
					EnableSubmitMode2();
				},
				252: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster fa-exclamation-triangle");
					$("#Mode2F1fa").addClass("fa-times-circle");
					$("#Mode2F1fa").css("color", "red");
					Toggle2F1 = 0;
					EnableSubmitMode2();
				},
				251: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster fa-exclamation-triangle");
					$("#Mode2F1fa").addClass("fa-times-circle");
					$("#Mode2F1fa").css("color", "darkorange");
					$("#Mode2F1fa").css("color", "red");
					Toggle2F1 = 0;
					EnableSubmitMode2();
				}
			},
			error: function() {
				// Error in input.
				TintPage("RED");
				$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster fa-exclamation-triangle");
				$("#Mode2F1fa").addClass("fa-exclamation-triangle");
				$("#Mode2F1fa").css("color", "darkorange");
				Toggle2F1 = 0;
				EnableSubmitMode2();
			}
		});
	});
	$("#Mode2F2").change(function() {
		$.ajax({
			type: 'POST',
			url: '/dev/redundant/email',
			timeout: 30000,
			data: {
				  EMail: $("#Mode2F2").val()
			},
			beforeSend: function(){
				TintPage("BLUE");
				$("#Mode2F2fa").removeClass("fa-ellipsis-h");
				$("#Mode2F2fa").addClass("fa-spinner fa-spin-faster");
				$("#Mode2F2fa").css("color", "teal");
			},
			statusCode: {
				253: function() {
					// Success. Available Email.
					TintPage("GREEN");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F2fa").addClass("fa-check-circle");
					$("#Mode2F2fa").css("color", "teal");
					Toggle2F2 = 1;
					EnableSubmitMode2();
				},
				252: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F2fa").addClass("fa-times-circle");
					$("#Mode2F2fa").css("color", "red");
					Toggle2F2 = 0;
					EnableSubmitMode2();
				},
				251: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F2fa").addClass("fa-times-circle");
					$("#Mode2F2fa").css("color", "darkorange");
					$("#Mode2F2fa").css("color", "red");
					Toggle2F2 = 0;
					EnableSubmitMode2();
				}
			},
			error: function() {
				// Error in input.
				TintPage("RED");
				$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster fa-exclamation-triangle");
				$("#Mode2F2fa").addClass("fa-exclamation-triangle");
				$("#Mode2F2fa").css("color", "darkorange");
				Toggle2F1 = 0;
				EnableSubmitMode2();
			}
		});
		EnableSubmitMode2();
	});
	$("#Mode2F3").keyup(function() {
		$("#Mode2F3fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
		if($("#Mode2F3").val().length < 6) {
			TintPage("RED");
			$("#Mode2F3fa").addClass("fa-times-circle");
			$("#Mode2F3fa").css("color", "red");
			Toggle2F3 = 0;
			EnableSubmitMode2();
		}
		else{
			TintPage("BLUE");
			$("#Mode2F3fa").addClass("fa-check-circle");
			$("#Mode2F3fa").css("color", "teal");
			Toggle2F3 = 1;
			EnableSubmitMode2();
		}
	});
	$("#Mode2F3").change(function() {
		$("#Mode2F4").val('');
		Toggle2F4 = 0;
		EnableSubmitMode2();
	});
	$("#Mode2F4").keyup(function() {
		$("#Mode2F4fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
		if($("#Mode2F4").val() != $("#Mode2F3").val()) {
			TintPage("RED");
			$("#Mode2F4fa").addClass("fa-times-circle");
			$("#Mode2F4fa").css("color", "red");
			Toggle2F4 = 0;
			EnableSubmitMode2();
		}
		else{
			TintPage("GREEN");
			$("#Mode2F4fa").addClass("fa-check-circle");
			$("#Mode2F4fa").css("color", "teal");
			Toggle2F4 = 1;
			EnableSubmitMode2();
		}
	});
	// Main Event: 
	$("#Mode2Btn").click(function() {
		if (Process2)
			return;
		$.ajax({
			type: 'POST',
			url: '/dev/account/add',
			data: {
				  UserName: $("#Mode2F1").val(),
				  EMail: $("#Mode2F2").val(),
				  Password: $("#Mode2F3").val(),
				  ConfPass: $("#Mode2F4").val()
			},
			timeout: 10000,
			beforeSend: function(){
				// Disable Click listener!
				Process2 = 1;

				// Tint Feedback
				TintPage("BLUE");

				// Change the button
				$("#Mode2Btn").html('<i class="fa fa-spinner fa-spin-faster"></i> Please Wait');
				$("#Mode2Btn").removeClass('btn-success');
				$("#Mode2Btn").addClass('btn-info');
				
				// Disable the Inputs
				$("#Mode2F1").attr("disabled","disabled");
				$("#Mode2F2").attr("disabled","disabled");
				$("#Mode2F3").attr("disabled","disabled");
				$("#Mode2F4").attr("disabled","disabled");
			},
			statusCode: {
				251: function(data) {
					// Success. User added.
					TintPage("GREEN");
					
					// Change the button
					$("#Mode2Btn").html('<i class="fa fa-check-circle"></i> Success! Please Wait.');
					$("#Mode2Btn").removeClass('btn-info');
					$("#Mode2Btn").addClass('btn-success');
					
					setTimeout(function() {
						window.location = data['Next'];
					}, 2000);
				},
				261: function() {
					// Nope. "Ho nhi paaya!"
					TintPage("RED");

					// Reset the Click Event.
					Process2 = 0;

					// Reset the Button.
					$("#Mode2Btn").html('<i class="fa fa-times-circle"></i> Sorry, Something went wrong.');
					$("#Mode2Btn").removeClass('btn-info');
					$("#Mode2Btn").addClass('btn-danger');

					$("#Mode2F1").removeAttr("disabled","disabled");
					$("#Mode2F2").removeAttr("disabled","disabled");
					$("#Mode2F3").removeAttr("disabled","disabled");
					$("#Mode2F4").removeAttr("disabled","disabled");

					setTimeout(function() {
						$("#Mode2Btn").html('Please Try Again');
						$("#Mode2Btn").removeClass('btn-danger');
						$("#Mode2Btn").addClass('btn-success');
					}, 3000);
				}
			},
			error: function() {
				// Nope. "Ho nhi paaya!"
				TintPage("RED");

				// Reset the Click Event.
				Process2 = 0;

				console.log('TimeOut Error, may have.');

				// Reset the Button.
				$("#Mode2Btn").html('<i class="fa fa-times-circle"></i> Sorry, Something went wrong.');
				$("#Mode2Btn").removeClass('btn-info');
				$("#Mode2Btn").addClass('btn-danger');

				$("#Mode2F1").removeAttr("disabled","disabled");
				$("#Mode2F2").removeAttr("disabled","disabled");
				$("#Mode2F3").removeAttr("disabled","disabled");
				$("#Mode2F4").removeAttr("disabled","disabled");

				setTimeout(function() {
					$("#Mode2Btn").html('Please Try Again');
					$("#Mode2Btn").removeClass('btn-danger');
					$("#Mode2Btn").addClass('btn-success');
				}, 3000);
			}
		});
	});

	// Submit Button Handeler.
	function EnableSubmitMode2() {
		Score = Toggle2F1+Toggle2F2+Toggle2F3+Toggle2F4;
		if(Score>=4) {
			$("#Mode2Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode2Btn").attr("disabled","disabled");
		}
	}

	// Init.
	EnableSubmitMode2();


	/**
	 * ..
	 */

	// Toggle for Set 3 of field.
	var Toggle3F1 = 0;

	// Toggle for Set 4 of field.
	var Toggle4F1 = 0;

	// Toggle for Set 5 of fields.
	var Toggle5F1 = 0;
	var Toggle5F2 = 0;

	// Init.
	EnableSubmitMode3();
	EnableSubmitMode4();
	EnableSubmitMode5();



	// Events handeled for Field set 3.
	$("#Mode3F1").keyup(function() {
		$("#Mode3F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
		if($("#Mode3F1").val().length!=5) {
			TintPage("RED");
			$("#Mode3F1fa").addClass("fa-times-circle");
			$("#Mode3F1fa").css("color", "red");
			Toggle3F1 = 0;
			EnableSubmitMode3();
		}
		else{
			TintPage("GREEN");
			$("#Mode3F1fa").addClass("fa-check-circle");
			$("#Mode3F1fa").css("color", "teal");
			Toggle3F1 = 1;
			EnableSubmitMode3();
		}
	});

	// Events handeled for Field set 4.
	$("#Mode4F1").change(function() {
		$.ajax({
			type: 'POST',
			url: '/dev/redundant/email',
			data: {
				  EMail: $("#Mode4F1").val()
			},
			beforeSend: function(){
				TintPage("BLUE");
				$("#Mode4F1fa").removeClass("fa-ellipsis-h");
				$("#Mode4F1fa").addClass("fa-spinner fa-spin-faster");
				$("#Mode4Btn").text('Processing...');	
				$("#Mode4F1fa").css("color", "teal");
				Toggle4F1 = 0;
				EnableSubmitMode4();
			},
			statusCode: {
				252: function() {
					// Success. Available Email.
					TintPage("BLUE");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode4F1fa").addClass("fa-check-circle");
					$("#Mode4F1fa").css("color", "teal");
					$("#Mode4Btn").text("Proceed");	
					Toggle4F1 = 1;
					EnableSubmitMode4();
				},
				253: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode4F1fa").addClass("fa-times-circle");
					$("#Mode4F1fa").css("color", "red");
					$("#Mode4Btn").text("EMail ID is not registered");	
					Toggle4F1 = 0;
					EnableSubmitMode4();
				},
				251: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode4F1fa").addClass("fa-times-circle");
					$("#Mode4F1fa").css("color", "darkorange");
					$("#Mode4F1fa").css("color", "red");
					$("#Mode4Btn").text("Invalid EMail ID");	
					Toggle4F1 = 0;
					EnableSubmitMode4();
				}
			}
		});
	});

	// Events handeled for Field set 5.
	$("#Mode5F1").keyup(function() {
		$("#Mode5F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
		if($("#Mode5F1").val().length < 6) {
			TintPage("RED");
			$("#Mode5F1fa").addClass("fa-times-circle");
			$("#Mode5F1fa").css("color", "red");
			Toggle5F1 = 0;
			EnableSubmitMode5();
		}
		else{
			TintPage("BLUE");
			$("#Mode5F1fa").addClass("fa-check-circle");
			$("#Mode5F1fa").css("color", "teal");
			Toggle5F1 = 1;
			EnableSubmitMode5();
		}
	});
	$("#Mode5F1").change(function() {
		$("#Mode5F2").val('');
		Toggle5F2 = 0;
		EnableSubmitMode5();
	});
	$("#Mode5F2").keyup(function() {
		$("#Mode5F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
		if($("#Mode5F2").val() != $("#Mode5F1").val()) {
			TintPage("RED");
			$("#Mode5F2fa").addClass("fa-times-circle");
			$("#Mode5F2fa").css("color", "red");
			Toggle5F2 = 0;
			EnableSubmitMode5();
		}
		else{
			TintPage("GREEN");
			$("#Mode5F2fa").addClass("fa-check-circle");
			$("#Mode5F2fa").css("color", "teal");
			Toggle5F2 = 1;
			EnableSubmitMode5();
		}
	});

	/**
	 * Tints the Page with a particular color.
	 */
	function TintPage(Target) {
		var Speed = 400;
		switch(Target) {
			case 'RED'		: 	$(".BG-Secondary-Green-Tint").fadeOut(Speed);
								$(".BG-Secondary-Red-Tint").fadeIn(Speed);
								$(".BG-Secondary-Blue-Tint").fadeOut(Speed);
								break;
			case 'GREEN'	: 	$(".BG-Secondary-Green-Tint").fadeIn(Speed);
								$(".BG-Secondary-Red-Tint").fadeOut(Speed);
								$(".BG-Secondary-Blue-Tint").fadeOut(Speed);
								break;
			case 'BLUE'		: 	$(".BG-Secondary-Green-Tint").fadeOut(Speed);
								$(".BG-Secondary-Red-Tint").fadeOut(Speed);
								$(".BG-Secondary-Blue-Tint").fadeIn(Speed);
								break;
		}
	}



	function EnableSubmitMode3() {
		Score = Toggle3F1;
		if(Score>=1) {
			$("#Mode3Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode3Btn").attr("disabled","disabled");
		}
	}

	function EnableSubmitMode4() {
		Score = Toggle4F1;
		if(Score>=1) {
			$("#Mode4Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode4Btn").attr("disabled","disabled");
		}
	}

	function EnableSubmitMode5() {
		Score = Toggle5F1 + Toggle5F2;
		if(Score>=2) {
			$("#Mode5Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode5Btn").attr("disabled","disabled");
		}
	}





});