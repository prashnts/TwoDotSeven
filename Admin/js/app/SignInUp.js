
$(function() {	

	var Blur = function afBlur() {
		$(".Bg-Gen-Hack").fadeIn(1600);
	}
	var UnBlur = function afunBlur() {
		//$(".Bg-Gen-Hack").fadeOut(400);
	}

	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F1, #Mode4F1, #Mode5F1, #Mode5F2")
		.focus(Blur);
	$("#Mode1F1, #Mode1F2, #Mode1F13, #Mode2F1, #Mode2F2, #Mode2F3, #Mode2F4, #Mode3F1, #Mode4F1, #Mode5F1, #Mode5F2")
		.blur(UnBlur);
	$("#MoodBlur").mousemove(Blur);


	// Toggles for Set 2 of fields.
	var Toggle2F1 = 0;
	var Toggle2F2 = 0;
	var Toggle2F3 = 0;
	var Toggle2F4 = 0;

	// Toggle for Set 3 of field.
	var Toggle3F1 = 0;

	// Toggle for Set 4 of field.
	var Toggle4F1 = 0;

	// Toggle for Set 5 of fields.
	var Toggle5F1 = 0;
	var Toggle5F2 = 0;

	// Init.
	EnableSubmitMode2();
	EnableSubmitMode3();
	EnableSubmitMode4();
	EnableSubmitMode5();

	// Events handeled for Field set 2.
	$("#Mode2F1").change(function() {
		$.ajax({
			type: 'POST',
			url: 'dev/ajax/IsUser',
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
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F1fa").addClass("fa-check-circle");
					$("#Mode2F1fa").css("color", "teal");
					Toggle2F1 = 1;
					EnableSubmitMode2();
				},
				252: function() {
					// Nope. Not available.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F1fa").addClass("fa-times-circle");
					$("#Mode2F1fa").css("color", "red");
					Toggle2F1 = 0;
					EnableSubmitMode2();
				},
				251: function() {
					// Error in input.
					TintPage("RED");
					$("#Mode2F1fa").removeClass("fa-ellipsis-h fa-check-circle fa-times-circle fa-spinner fa-spin-faster");
					$("#Mode2F1fa").addClass("fa-times-circle");
					$("#Mode2F1fa").css("color", "darkorange");
					$("#Mode2F1fa").css("color", "red");
					Toggle2F1 = 0;
					EnableSubmitMode2();
				}
			}
		});
	});
	$("#Mode2F2").change(function() {
		$.ajax({
			type: 'POST',
			url: 'dev/ajax/IsEMail',
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
			url: 'dev/ajax/IsEMail',
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

	// Supporting functions.
	function TintPage(Target) {
		var Speed = 300;
		switch(Target) {
			case 'RED'		: 	$(".Bg-Gen-Hack-Green-Tint").fadeOut(Speed);
								$(".Bg-Gen-Hack-Red-Tint").fadeIn(Speed);
								$(".Bg-Gen-Hack-Blue-Tint").fadeOut(Speed);
								break;
			case 'GREEN'	: 	$(".Bg-Gen-Hack-Green-Tint").fadeIn(Speed);
								$(".Bg-Gen-Hack-Red-Tint").fadeOut(Speed);
								$(".Bg-Gen-Hack-Blue-Tint").fadeOut(Speed);
								break;
			case 'BLUE'		: 	$(".Bg-Gen-Hack-Green-Tint").fadeOut(Speed);
								$(".Bg-Gen-Hack-Red-Tint").fadeOut(Speed);
								$(".Bg-Gen-Hack-Blue-Tint").fadeIn(Speed);
								break;
		}
	}

	function EnableSubmitMode2() {
		Score = Toggle2F1+Toggle2F2+Toggle2F3+Toggle2F4;
		if(Score>=4) {
			$("#Mode2Btn").removeAttr("disabled","disabled");
		}
		else {
			$("#Mode2Btn").attr("disabled","disabled");
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