/**
 * Number Cheats:
 * 1 -
 * 2 - Sign Up 
 * 3 - Confirm Email, Username not given.
 * 4 - Confirm Email, Username is given by user.
 */

console.log(" _____           ____      _      ___       __ _____ ");
console.log("|_   _|_ _ _ ___|    \ ___| |_   |_  |   __|  |   __|");
console.log("  | | | | | | . |  |  | . |  _|    | |  |  |  |__   |");
console.log("  |_| |_____|___|____/|___|_|      |_|  |_____|_____|");
console.log("                                                     ");
console.log("\"I thought of writing something Cool, Witty and Catchy here.");
console.log("But then I got Hungry.\"");
console.log("-Prashant S.");
console.log("TwoDot7 is a project in development. You can help take it shape.");
console.log("Push your changes to github.com/PrashntS/TwoDotSeven");
console.log("DEBUG MODE: Script Loaded Succesfully.");

console.log("Checking UserCookie .... Ok.");
console.log("Checking HashCookie .... Inaccessible. Ok.");

$(function() {	
	var Blur = function afBlur() {
		$(".BG-Secondary").fadeIn(900);
	}
	var UnBlur = function afunBlur() {
		//$(".Bg-Gen-Hack").fadeOut(400);
	}

	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F2, #Mode4F1, #Mode5F1, #Mode5F2")
		.focus(Blur);
	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F2, #Mode4F1, #Mode5F1, #Mode5F2")
		.blur(UnBlur);
	$("#MoodBlur").mousemove(Blur);


	/**
	 * Toggles/Methods for the Sign Up Page. Number 2
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
				$("#Mode2F1fa").addClass("fa-circle-o-notch fa-spin");
				$("#Mode2F1fa").css("color", "teal");
			},
			statusCode: {
				253: function() {
					// Success. Available username.
					TintPage("GREEN");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
					$("#Mode2F1fa").addClass("fa-check-circle");
					$("#Mode2F1fa").css("color", "teal");
					Toggle2F1 = 1;
					EnableSubmitMode2();
				},
				252: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
					$("#Mode2F1fa").addClass("fa-times-circle");
					$("#Mode2F1fa").css("color", "red");
					Toggle2F1 = 0;
					EnableSubmitMode2();
				},
				262: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
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
				$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
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
				$("#Mode2F2fa").addClass("fa-circle-o-notch fa-spin");
				$("#Mode2F2fa").css("color", "teal");
			},
			statusCode: {
				253: function() {
					// Success. Available Email.
					TintPage("GREEN");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin");
					$("#Mode2F2fa").addClass("fa-check-circle");
					$("#Mode2F2fa").css("color", "teal");
					Toggle2F2 = 1;
					EnableSubmitMode2();
				},
				252: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin");
					$("#Mode2F2fa").addClass("fa-times-circle");
					$("#Mode2F2fa").css("color", "red");
					Toggle2F2 = 0;
					EnableSubmitMode2();
				},
				262: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin");
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
				$("#Mode2F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
				$("#Mode2F2fa").addClass("fa-exclamation-triangle");
				$("#Mode2F2fa").css("color", "darkorange");
				Toggle2F1 = 0;
				EnableSubmitMode2();
			}
		});
		EnableSubmitMode2();
	});
	$("#Mode2F3").keyup(function() {
		$("#Mode2F3fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin");
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
		$("#Mode2F4fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin");
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

	// Handle Return Key Event:
	$("#Mode2F3, #Mode2F4").on('keydown', function(eventData) {
		if (eventData.which == 13) {
			if (EnableSubmitMode2() >= 4) {
				eventData.preventDefault();
				$("#Mode2Btn").click();
			}
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
				$("#Mode2Btn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Please Wait');
				$("#Mode2Btn").removeClass('btn-success');
				$("#Mode2Btn").addClass('btn-info');
				
				// Disable the Inputs
				$("#Mode2F1").attr("disabled","disabled");
				$("#Mode2F2").attr("disabled","disabled");
				$("#Mode2F3").attr("disabled","disabled");
				$("#Mode2F4").attr("disabled","disabled");
			},
			statusCode: {
				262: function(data) {
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
		return Score;
	}

	// Init.
	EnableSubmitMode2();


	/**
	 * Toggles/Methods for the EMail Confirmation Page, when UserName is not provided by the User.
	 * @author Prahant Sinha
	 */
	// Toggles
	var Toggle3F2 = 0;
	var Process3 = 0;

	// Events handeled.
	$("#Mode3F2").keyup(function() {
		$("#Mode3F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-circle fa-times-circle fa-circle-o-notch fa-spin");
		if($("#Mode3F2").val().length!=6) {
			TintPage("RED");
			$("#Mode3F2fa").addClass("fa-times-circle");
			$("#Mode3F2fa").css("color", "red");
			Toggle3F2 = 0;
			EnableSubmitMode3();
		}
		else{
			TintPage("BLUE");
			$("#Mode3F2fa").addClass("fa-circle");
			$("#Mode3F2fa").css("color", "#5E9D9F");
			Toggle3F2 = 1;
			EnableSubmitMode3();
		}
	});

	// Handle Return Key Event:
	$("#Mode3F2").on('keydown', function(eventData) {
		if (eventData.which == 13) {
			if (EnableSubmitMode3() >= 1) {
				eventData.preventDefault();
				$("#Mode3Btn").click();
			}
		}
	});

	// Main Event: 
	$("#Mode3Btn").click(function() {
		if (Process3)
			return;
		$.ajax({
			type: 'POST',
			url: '/dev/account/confirmEmail',
			data: {
				UserName: $("#Mode3F1").val(),
				ConfirmationCode: $("#Mode3F2").val()
			},
			timeout: 10000,
			beforeSend: function(){
				// Disable Click listener!
				Process3 = 1;

				// Tint Feedback
				TintPage("BLUE");

				// Change the button
				$("#Mode3Btn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Please Wait');
				$("#Mode3Btn").removeClass('btn-success');
				$("#Mode3Btn").addClass('btn-info');
				
				// Disable the Inputs
				$("#Mode3F2").attr("disabled","disabled");
			},
			statusCode: {
				250: function(data) {
					// Repeated Action.
					TintPage("BLUE");
					
					// Change the button
					$("#Mode3Btn").html('<i class="fa fa-check-circle"></i> Email Already Confirmed.');
					$("#Mode3Btn").removeClass('btn-info');
					$("#Mode3Btn").addClass('btn-warning');
					
					setTimeout(function() {
						window.location = '/';
					}, 3000);
				},
				262: function(data) {
					// Success. User added.
					TintPage("GREEN");
					
					// Change the button
					$("#Mode3Btn").html('<i class="fa fa-check-circle"></i> Success! Please Wait.');
					$("#Mode3Btn").removeClass('btn-info');
					$("#Mode3Btn").addClass('btn-success');
					
					setTimeout(function() {
						window.location = '/';
					}, 3000);
				},
				261: function() {
					// Nope. "Ho nhi paaya!"
					TintPage("RED");

					// Reset the Click Event.
					Process3 = 0;

					// Reset the Button.
					$("#Mode3Btn").html('<i class="fa fa-times-circle"></i> Please check Confirmation Code.');
					$("#Mode3Btn").removeClass('btn-info');
					$("#Mode3Btn").addClass('btn-danger');

					$("#Mode3F2").removeAttr("disabled","disabled");

					setTimeout(function() {
						$("#Mode3Btn").html('Please Try Again');
						$("#Mode3Btn").removeClass('btn-danger');
						$("#Mode3Btn").addClass('btn-success');
					}, 3000);
				}
			},
			error: function() {
				// Nope. "Ho nhi paaya!"
				TintPage("RED");

				// Reset the Click Event.
				Process3 = 0;

				console.log('TimeOut Error, may have.');

				// Reset the Button.
				$("#Mode3Btn").html('<i class="fa fa-times-circle"></i> Sorry, Something went wrong.');
				$("#Mode3Btn").removeClass('btn-info');
				$("#Mode3Btn").addClass('btn-danger');

				$("#Mode3F2").removeAttr("disabled","disabled");

				setTimeout(function() {
					$("#Mode3Btn").html('Please Try Again');
					$("#Mode3Btn").removeClass('btn-danger');
					$("#Mode3Btn").addClass('btn-success');
				}, 3000);
			}
		});
	});

	// Submit Button Handeler.
	function EnableSubmitMode3() {
		Score = Toggle3F2;
		if(Score==1) {
			$("#Mode3Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode3Btn").attr("disabled","disabled");
		}
		return Score;
	}

	// Init.
	EnableSubmitMode3();


	/**
	 * Toggles/Methods for the EMail Confirmation Page, when UserName is provided by the User.
	 * @author Prahant Sinha
	 */
	// Toggles
	var Toggle4F1 = 0;
	var Toggle4F2 = 0;
	var Process4 = 0;

	// Events handeled.
	$("#Mode4F1").change(function() {
		$.ajax({
			type: 'POST',
			url: '/dev/redundant/username',
			timeout: 30000,
			data: {
				  UserName: $("#Mode4F1").val()
			},
			beforeSend: function(){
				TintPage("BLUE");
				$("#Mode4F1fa").removeClass("fa-ellipsis-h");
				$("#Mode4F1fa").addClass("fa-circle-o-notch fa-spin");
				$("#Mode4F1fa").css("color", "teal");
			},
			statusCode: {
				252: function() {
					TintPage("GREEN");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
					$("#Mode4F1fa").addClass("fa-check-circle");
					$("#Mode4F1fa").css("color", "teal");
					Toggle4F1 = 1;
					EnableSubmitMode4();
				},
				253: function() {
					TintPage("RED");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
					$("#Mode4F1fa").addClass("fa-times-circle");
					$("#Mode4F1fa").css("color", "red");
					Toggle4F1 = 0;
					EnableSubmitMode4();
					Restore = $("#Mode4Btn").html();
					$("#Mode4Btn").html('<i class="fa fa-times-circle"></i> This UserName doesn\'t exists.');
					$("#Mode4Btn").removeClass('btn-success');
					$("#Mode4Btn").addClass('btn-danger');
					setTimeout(function(){
						$("#Mode4Btn").html('Please try Again.');
						$("#Mode4Btn").addClass('btn-success');
						$("#Mode4Btn").removeClass('btn-danger');
					}, 3000);

				},
				262: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
					$("#Mode4F1fa").addClass("fa-times-circle");
					$("#Mode4F1fa").css("color", "darkorange");
					$("#Mode4F1fa").css("color", "red");
					Toggle4F1 = 0;
					EnableSubmitMode4();
				}
			},
			error: function() {
				// Error in input.
				TintPage("RED");
				$("#Mode4F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-circle-o-notch fa-spin fa-exclamation-triangle");
				$("#Mode4F1fa").addClass("fa-exclamation-triangle");
				$("#Mode4F1fa").css("color", "darkorange");
				Toggle4F1 = 0;
				EnableSubmitMode4();
			}
		});
	});
	$("#Mode4F2").keyup(function() {
		$("#Mode4F2fa").removeClass("fa-ellipsis-h fa-check-circle fa-circle fa-times-circle fa-circle-o-notch fa-spin");
		if($("#Mode4F2").val().length!=6) {
			TintPage("RED");
			$("#Mode4F2fa").addClass("fa-times-circle");
			$("#Mode4F2fa").css("color", "red");
			Toggle4F2 = 0;
			EnableSubmitMode4();
		}
		else{
			TintPage("BLUE");
			$("#Mode4F2fa").addClass("fa-circle");
			$("#Mode4F2fa").css("color", "#5E9D9F");
			Toggle4F2 = 1;
			EnableSubmitMode4();
		}
	});

	// Handle Return Key Event:
	$("#Mode4F2").on('keydown', function(eventData) {
		if (eventData.which == 13) {
			if (EnableSubmitMode4() >= 2) {
				eventData.preventDefault();
				$("#Mode4Btn").click();
			}
		}
	});

	// Main Event: 
	$("#Mode4Btn").click(function() {
		if (Process4)
			return;
		$.ajax({
			type: 'POST',
			url: '/dev/account/confirmEmail',
			data: {
				UserName: $("#Mode4F1").val(),
				ConfirmationCode: $("#Mode4F2").val()
			},
			timeout: 10000,
			beforeSend: function(){
				// Disable Click listener!
				Process4 = 1;

				// Tint Feedback
				TintPage("BLUE");

				// Change the button
				$("#Mode4Btn").html('<i class="fa fa-circle-o-notch fa-spin"></i> Please Wait');
				$("#Mode4Btn").removeClass('btn-success');
				$("#Mode4Btn").addClass('btn-info');
				
				// Disable the Inputs
				$("#Mode4F2").attr("disabled","disabled");
			},
			statusCode: {
				250: function(data) {
					// Repeated Action.
					TintPage("BLUE");
					
					// Change the button
					$("#Mode4Btn").html('<i class="fa fa-check-circle"></i> Email Already Confirmed.');
					$("#Mode4Btn").removeClass('btn-info');
					$("#Mode4Btn").addClass('btn-warning');
					
					setTimeout(function() {
						window.location = '/';
					}, 3000);
				},
				262: function(data) {
					// Success. User added.
					TintPage("GREEN");
					
					// Change the button
					$("#Mode4Btn").html('<i class="fa fa-check-circle"></i> Success! Please Wait.');
					$("#Mode4Btn").removeClass('btn-info');
					$("#Mode4Btn").addClass('btn-success');
					
					setTimeout(function() {
						window.location = '/';
					}, 3000);
				},
				261: function() {
					// Nope. "Ho nhi paaya!"
					TintPage("RED");

					// Reset the Click Event.
					Process4 = 0;

					// Reset the Button.
					$("#Mode4Btn").html('<i class="fa fa-times-circle"></i> Please check Confirmation Code.');
					$("#Mode4Btn").removeClass('btn-info');
					$("#Mode4Btn").addClass('btn-danger');

					$("#Mode4F2").removeAttr("disabled","disabled");

					setTimeout(function() {
						$("#Mode4Btn").html('Please Try Again');
						$("#Mode4Btn").removeClass('btn-danger');
						$("#Mode4Btn").addClass('btn-success');
					}, 3000);
				}
			},
			error: function() {
				// Nope. "Ho nhi paaya!"
				TintPage("RED");

				// Reset the Click Event.
				Process4 = 0;

				console.log('TimeOut Error, may have.');

				// Reset the Button.
				$("#Mode4Btn").html('<i class="fa fa-times-circle"></i> Sorry, Something went wrong.');
				$("#Mode4Btn").removeClass('btn-info');
				$("#Mode4Btn").addClass('btn-danger');

				$("#Mode4F2").removeAttr("disabled","disabled");

				setTimeout(function() {
					$("#Mode4Btn").html('Please Try Again');
					$("#Mode4Btn").removeClass('btn-danger');
					$("#Mode4Btn").addClass('btn-success');
				}, 3000);
			}
		});
	});

	// Submit Button Handeler.
	function EnableSubmitMode4() {
		Score = Toggle4F1 + Toggle4F2;
		if(Score>=2) {
			$("#Mode4Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode4Btn").attr("disabled","disabled");
		}
		return Score;
	}

	// Init.
	EnableSubmitMode4();

	/**
	 * Tints the Page with a particular color.
	 */
	function TintPage(Target) {
		var Speed = 400;
		switch(Target) {
			case 'RED':
				$(".BG-Secondary-Green-Tint").fadeOut(Speed);
				$(".BG-Secondary-Red-Tint").fadeIn(Speed);
				$(".BG-Secondary-Blue-Tint").fadeOut(Speed);
				break;
			case 'GREEN':
				$(".BG-Secondary-Green-Tint").fadeIn(Speed);
				$(".BG-Secondary-Red-Tint").fadeOut(Speed);
				$(".BG-Secondary-Blue-Tint").fadeOut(Speed);
				break;
			case 'BLUE':
				$(".BG-Secondary-Green-Tint").fadeOut(Speed);
				$(".BG-Secondary-Red-Tint").fadeOut(Speed);
				$(".BG-Secondary-Blue-Tint").fadeIn(Speed);
				break;
		}
	}
});