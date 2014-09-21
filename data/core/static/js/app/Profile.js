var DesignationPrevious = $("#DesignationPrevious").val();
var DesignationToggle = 0;
var StopPropogation = false;
PutIconInButton(TranslateDesignationCodeToId(Number(DesignationPrevious)==0?'LOL':Number(DesignationPrevious)), 'Check', true);
Number(DesignationPrevious) > 3 ? PutIconInButton("OptionAdmin", 'Down', true) : true;

$("#OptionStudent").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(1);
	ShowMetaArea(8);
	ShowMetaArea(1);
	ShowMetaArea(5);
	DesignationToggle = 1;
	ResetDesignationButtons();
	PutIconInButton("OptionStudent", 'Down', true);
});
$("#OptionFaculty").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(2);
	ShowMetaArea(8);
	ShowMetaArea(2);
	ShowMetaArea(5);
	DesignationToggle = 2;
	ResetDesignationButtons();
	PutIconInButton("OptionFaculty", 'Down', true);
});
$("#OptionStaff").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(3);
	ShowMetaArea(8);
	ShowMetaArea(3);
	ShowMetaArea(5);
	DesignationToggle = 3;
	ResetDesignationButtons();
	PutIconInButton("OptionStaff", 'Down', true);
});
$("#OptionAdmin").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(7);
	ShowMetaArea(0);
	ShowMetaArea(7);
	DesignationToggle = 0;
	ResetDesignationButtons();
	PutIconInButton("OptionAdmin", 'Down', true);
});
$("#OptionStudentSec").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(4);
	ShowMetaArea(1);
	ShowMetaArea(5);
	DesignationToggle = 4;
	ResetDesignationButtons();
	PutIconInButton("OptionAdmin", 'Down', true);
	PutIconInButton("OptionStudentSec", 'Down', true);
});
$("#OptionFacultySec").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(5);
	ShowMetaArea(2);
	ShowMetaArea(5);
	DesignationToggle = 5;
	ResetDesignationButtons();
	PutIconInButton("OptionAdmin", 'Down', true);
	PutIconInButton("OptionFacultySec", 'Down', true);
});
$("#OptionStaffSec").click(function(){
	if (StopPropogation) return 'Nope.';
	TintBG(6);
	ShowMetaArea(3);
	ShowMetaArea(5);
	DesignationToggle = 6;
	ResetDesignationButtons();
	PutIconInButton("OptionAdmin", 'Down', true);
	PutIconInButton("OptionStaffSec", 'Down', true);
});
$("#DesignationConfirmBtnProceed").click(function(){
	ResetDesignationButtons();
	ShowMetaArea(6);
	StopPropogation = true;
	$.ajax({
		type: 'POST',
		timeout: 20000,
		url: 'dev/user/'+getCookie('UserNameCookie')+'/PutMeta',
		cache: false,
		data: {
			AuthMode:		1,
			AuthUser:		getCookie('UserNameCookie'),
			AuthHash:		getCookie('UserHashCookie'),
			Designation:	DesignationToggle
		},
		beforeSend: function(){
			PutIconInButton(TranslateDesignationCodeToId(DesignationToggle), 'Spin', true);
			ShowMetaArea(14);
			TintBG(7);
		},
		statusCode: {
			251: function() {
				// Success, but Re-Activation Required.
				StopPropogation = false;
				TintBG(DesignationToggle);
				ShowMetaArea(15);
				PutIconInButton(TranslateDesignationCodeToId(DesignationToggle), 'Check', true);
				DesignationPrevious = DesignationToggle;
				PutMessage("<kbd>Successfully Updated the Designation. Your Account requires (re)verification.</kbd>");
				
			},
			250: function() {
				// Success.
				StopPropogation = false;
				TintBG(DesignationToggle);
				ShowMetaArea(15);
				PutIconInButton(TranslateDesignationCodeToId(DesignationToggle), 'Check', true);
				DesignationPrevious = DesignationToggle;
				PutMessage("Successfully Updated the Designation. No further action is required.");
			},
			260: function() {
				ResetDesignationButtons();
				ShowMetaArea(15);
				TintBG(Number(DesignationPrevious));
				StopPropogation = false;
				PutIconInButton(TranslateDesignationCodeToId(Number(DesignationPrevious)), 'Error', true);
				PutIconInButton(TranslateDesignationCodeToId(Number(DesignationToggle)), 'Error', false);
				switch(Number(DesignationPrevious)) {
					case 1:
					case 4: ShowMetaArea(1); break;
					case 2:
					case 5: ShowMetaArea(2); break;
					case 3:
					case 6: ShowMetaArea(3); break;
				}
				switch(Number(DesignationPrevious)) {
					case 4:
					case 5:
					case 6: ShowMetaArea(7); break;
				}
				PutMessage("Please try Again. Some internal server error occured.");
				DesignationToggle = DesignationPrevious;
			}
		},
		error: function(){
			ResetDesignationButtons();
			ShowMetaArea(15);
			TintBG(Number(DesignationPrevious));
			StopPropogation = false;
			PutIconInButton(TranslateDesignationCodeToId(Number(DesignationPrevious)), 'Check', true);
			PutIconInButton(TranslateDesignationCodeToId(Number(DesignationToggle)), 'Error', false);
			switch(Number(DesignationPrevious)) {
				case 1:
				case 4: ShowMetaArea(1); break;
				case 2:
				case 5: ShowMetaArea(2); break;
				case 3:
				case 6: ShowMetaArea(3); break;
			}
			switch(Number(DesignationPrevious)) {
				case 4:
				case 5:
				case 6: ShowMetaArea(7); break;
			}
			PutMessage("Please try Again. Your request timed-out.");
			DesignationToggle = DesignationPrevious;
		}
	});
});
$("#DesignationConfirmBtnReset").click(function(){
	ResetDesignationButtons();
	ShowMetaArea(9);
	TintBG(Number(DesignationPrevious));
	StopPropogation = false;
	PutIconInButton(TranslateDesignationCodeToId(Number(DesignationPrevious)), 'Check', true);
	PutIconInButton(TranslateDesignationCodeToId(Number(DesignationToggle)), 'Error', false);
	switch(Number(DesignationPrevious)) {
		case 1:
		case 4: ShowMetaArea(1); break;
		case 2:
		case 5: ShowMetaArea(2); break;
		case 3:
		case 6: ShowMetaArea(3); break;
	}
});

var flag=true;
$(".overlay-transparent").hover(
	function(){
		if(flag)
		$("#overlay").filter(':not(:animated)').fadeIn('fast');
	},
	function(){
		if(flag)
		$("#overlay").fadeOut('fast');
	}
);
$(".overlay-transparent").click(function(){
	$(".overlay-transparent")
	flag=false;
});

function PutMessage(text) {
	$("#AJAXResponse").dequeue().hide("");
	$("#AJAXResponse").show("").text(text).delay(5000).hide("");
}
function TintBG(Code) {
	/**
	 ** Animates the Background Color.
	 ** @param Code: Specifies the Action.
	 ** @param Code -> 1: Animates to Student Color: Blue.
	 ** @param Code -> 2: Animates to Faculty Color: Teal.
	 ** @param Code -> 3: Animates to Staff Color: Violet.
	 ** @param Code -> 4: Animates to Admin Color: Black.
	 ** @param Code -> 5: Animates to Admin Color: Black.
	 ** @param Code -> 6: Animates to Admin Color: Black.
	 ** @return: boolean
	 ** @author: Prashant Sinha, <first name><last name>@[ducic.ac.in, outlook.com]
	 ** @version: 0.1, 09062014
	**/
	var Speed = 300;
	switch(Code) {
		case 1 :	$('#UserProfileEditColorStudent').fadeIn(Speed);
					$('#UserProfileEditColorFaculty').fadeOut(Speed);
					$('#UserProfileEditColorStaff').fadeOut(Speed);
					$('#UserProfileEditColorAdmin').fadeOut(Speed);
					$('#UserProfileEditColorLoading').fadeOut(Speed);
					break;
		case 2 :	$('#UserProfileEditColorStudent').fadeOut(Speed);
					$('#UserProfileEditColorFaculty').fadeIn(Speed);
					$('#UserProfileEditColorStaff').fadeOut(Speed);
					$('#UserProfileEditColorAdmin').fadeOut(Speed);
					$('#UserProfileEditColorLoading').fadeOut(Speed);
					break;
		case 3 :	$('#UserProfileEditColorStudent').fadeOut(Speed);
					$('#UserProfileEditColorFaculty').fadeOut(Speed);
					$('#UserProfileEditColorStaff').fadeIn(Speed);
					$('#UserProfileEditColorAdmin').fadeOut(Speed);
					$('#UserProfileEditColorLoading').fadeOut(Speed);
					break;
		case 4 :
		case 5 :
		case 6 :	$('#UserProfileEditColorStudent').fadeOut(Speed);
					$('#UserProfileEditColorFaculty').fadeOut(Speed);
					$('#UserProfileEditColorStaff').fadeOut(Speed);
					$('#UserProfileEditColorAdmin').fadeIn(Speed);
					$('#UserProfileEditColorLoading').fadeOut(Speed);
					break;
		case 7 :	$('#UserProfileEditColorStudent').fadeOut(Speed);
					$('#UserProfileEditColorFaculty').fadeOut(Speed);
					$('#UserProfileEditColorStaff').fadeOut(Speed);
					$('#UserProfileEditColorAdmin').fadeOut(Speed);
					$('#UserProfileEditColorLoading').fadeIn(Speed);
					break;
		case 9 :
		default :	$('#UserProfileEditColorStudent').fadeOut(Speed);
					$('#UserProfileEditColorFaculty').fadeOut(Speed);
					$('#UserProfileEditColorStaff').fadeOut(Speed);
					$('#UserProfileEditColorAdmin').fadeOut(Speed);
					$('#UserProfileEditColorLoading').fadeOut(Speed);
					return false;
					break;
	}
	return true;
}
function ShowMetaArea(Code) {
	/**
	 ** Animates the PutMeta Area.
	 ** @param Code: Specifies the Action.
	 ** @param Code -> 1: Shows the Student Meta Editor.
	 ** @param Code -> 2: Shows the Faculty Meta Editor.
	 ** @param Code -> 3: Shows the Staff Meta Editor.
	 ** @param Code -> 5: Shows the Designation Change Confirmation.
	 ** @param Code -> 6: Hides the Designation Change Confirmation.
	 ** @param Code -> 7: Shows the Admin Option Choice.
	 ** @param Code -> 8: Hides the Admin Option Choice.
	 ** @param Code -> 9: Hides all the Meta Stuffs.
	 ** @return: boolean
	 ** @author: Prashant Sinha, <first name><last name>@[ducic.ac.in, outlook.com]
	 ** @version: 0.1, 09062014
	**/
	var Effect = "blind";	// Requires jquery UI.
	switch(Code) {
		case 1 :	$("#StudentDetail").show(Effect);
					$("#FacultyDetail").hide(Effect);
					$("#StaffDetail").hide(Effect);
					break;
		case 2 :	$("#StudentDetail").hide(Effect);
					$("#FacultyDetail").show(Effect);
					$("#StaffDetail").hide(Effect);
					break;
		case 3 :	$("#StudentDetail").hide(Effect);
					$("#FacultyDetail").hide(Effect);
					$("#StaffDetail").show(Effect);
					break;
		case 5 :	$("#DesignationConfirm").show(Effect);
					break;
		case 6 :	$("#DesignationConfirm").hide(Effect);
					break;
		case 7 :	$("#AdminOptions").show(Effect);
					break;
		case 8 :	$("#AdminOptions").hide(Effect);
					break;
		case 9 :	$("#StudentDetail").hide(Effect);
					$("#FacultyDetail").hide(Effect);
					$("#StaffDetail").hide(Effect);
					$("#AdminOptions").hide(Effect);
					$("#DesignationConfirm").hide(Effect);
					break;
		case 14:	$("#AJAXLoading").fadeIn().show(Effect);
					break;
		case 15:	$("#AJAXLoading").fadeOut().hide(Effect);
					break;
		case 0 :
		default :	$("#StudentDetail").hide(Effect);
					$("#FacultyDetail").hide(Effect);
					$("#StaffDetail").hide(Effect);
					$("#AdminOptions").hide(Effect);
					$("#DesignationConfirm").hide(Effect);
					return false;
					break;
	}
	return true;
}
function PutIconInButton(Selector, Icon, Activate) {
	Activate == true ? $("#" + Selector).addClass("active") : $("#" + Selector).removeClass("active");
	Icon == 'Error' ? $("#" + Selector + " i").removeClass().addClass("fa fa-exclamation-triangle") : true;
	Icon == 'Check' ? $("#" + Selector + " i").removeClass().addClass("fa fa-check") : true;
	Icon == 'Spin' ? $("#" + Selector + " i").removeClass().addClass("fa fa-spinner fa-spin") : true;
	Icon == 'Down' ? $("#" + Selector + " i").removeClass().addClass("fa fa-arrow-circle-down") : true;
	Icon == 'Nope' ? $("#" + Selector + " i").removeClass() : true;
}
function ResetDesignationButtons() {
	for(i=0; i<7; i++) {
		PutIconInButton(TranslateDesignationCodeToId(i), "Nope", false);
	}
}
function TranslateDesignationCodeToId(Code) {
	switch(Code) {
		case 0 : return "OptionAdmin";
		case 1 : return "OptionStudent";
		case 2 : return "OptionFaculty";
		case 3 : return "OptionStaff";
		case 4 : return "OptionStudentSec";
		case 5 : return "OptionFacultySec";
		case 6 : return "OptionStaffSec";
		default: return "LOLFakYu";
	}
}

// Profile Info Saving Handles:
$("#BtnSave").click(function() {
	if (StopPropogation) return 'Nope.';
	var Data = {};
	$('input[name=dName]').val().length ? (Data['Name'] = $('input[name=dName]').val()) : true;
	$('input[name=dCode]').val().length ? (Data['MetaCode'] = $('input[name=dCode]').val()) : true;
	$('input[name=dCourse]:radio:checked').val() ? Data['MetaCourse'] = $('input[name=dCourse]:radio:checked').val() : true;
	$('input[name=dSemester]:radio:checked').val() ? Data['MetaSemester'] = Number($('input[name=dSemester]:radio:checked').val()) : true;
	$('input[name=dDesignationMetaFaculty]').val().length ? Data['MetaDesignation'] = $('input[name=dDesignationMetaFaculty]').val() :true;
	$('input[name=dDesignationMetaStaff]').val().length ? Data['MetaTitle'] = $('input[name=dDesignationMetaStaff]').val() :true;
	$('input[name=dDateOfBirth]').val().length ? (Data['MiscDateOfBirth'] = $('input[name=dDateOfBirth]').val()) : true;
	$('input[name=dCellPhone]').val().length ? (Data['MiscCellPhone'] = $('input[name=dCellPhone]').val()) : true;
	$('input[name=dGender]:radio:checked').val() ? Data['MiscGender'] = $('input[name=dGender]:radio:checked').val() : true;
	$('textarea[name=dAddress]').val().length ? (Data['MiscAddress'] = $('textarea[name=dAddress]').val()) : true;
	
	Data['AuthMode'] = 1;
	Data['AuthUser'] =	getCookie('UserNameCookie'),
	Data['AuthHash'] =	getCookie('UserHashCookie'),
	$.ajax({
		type: 'POST',
		timeout: 20000,
		url: 'dev/user/'+getCookie('UserNameCookie')+'/PutMeta',
		cache: false,
		data: Data,
		beforeSend: function(){
			PutIconInButton("BtnSave", "Spin", true)
			StopPropogation = true; // Disable Buttons.
			ResetBorders();
			ShowMetaArea(14);
			TintBG(7);
		},
		statusCode: {
			251: function(data) {
				// Success, but Re-Activation Required.
				StopPropogation = false;
				TintBG(DesignationPrevious);
				ShowMetaArea(15);
				PutIconInButton("BtnSave", 'Check', true)
				setTimeout(function () {
					PutIconInButton("BtnSave", 'Nope', true);
				}, 3000)
				PutSuccess(data);
				PutMessage("Successfully Updated Your Profile. Your Account requires (re)verification.");
			},
			250: function(data) {
				// Success.
				StopPropogation = false;
				TintBG(DesignationPrevious);
				ShowMetaArea(15);
				PutIconInButton("BtnSave", 'Check', true)
				setTimeout(function () {
					PutIconInButton("BtnSave", 'Nope', true);
				}, 3000);
				PutSuccess(data);
				PutMessage("Successfully Updated Your Profile.");
			},
			260: function(data) {
				ShowMetaArea(15);
				TintBG(DesignationPrevious);
				StopPropogation = false; // Enable Buttons.
				PutHasError(data);
				PutIconInButton("BtnSave", 'Error', true)
				setTimeout(function () {
					PutIconInButton("BtnSave", 'Nope', true);
				}, 3000)
				PutMessage("There seem to be a few errors in your input. Please correct them.");
			}
		},
		error: function(){
			ShowMetaArea(15);
			TintBG(DesignationPrevious);
			StopPropogation = false;
			PutIconInButton("BtnSave", 'Error', true)
			setTimeout(function () {
				PutIconInButton("BtnSave", 'Nope', true);
			}, 3000)
			PutMessage("Sorry, but this request failed. Perhaps there is some eror in your Internet Connection?");
		}
	});
});

function PutBorders(Selector, Color) {

	$(Selector).attr("style","border-color:"+Color);
}
function ResetBorders() {
	PutBorders('input[name=dName]', "inherit");
	PutBorders('input[name=dDesignationMetaStaff]', "inherit");
	PutBorders('input[name=dDesignationMetaFaculty]', "inherit");
	PutBorders('input[name=dCode]', "inherit");
	PutBorders('input[name=dDateOfBirth]', "inherit");
	PutBorders('input[name=dCellPhone]', "inherit");
	PutBorders('textarea[name=dAddress]', "inherit");
}
function PutHasError(data) {
	data['isValid']['Name']							? true : PutBorders('input[name=dName]', "#DD0101");
	data['isValid']['DesignationMetaTitle']			? true : PutBorders('input[name=dDesignationMetaStaff]', "#DD0101");
	data['isValid']['DesignationMetaDesignation']	? true : PutBorders('input[name=dDesignationMetaFaculty]', "#DD0101");
	data['isValid']['DesignationMetaCode']			? true : PutBorders('input[name=dCode]', "#DD0101");
	data['isValid']['MiscDateOfBirth']				? true : PutBorders('input[name=dDateOfBirth]', "#DD0101");
	data['isValid']['CellPhone']					? true : PutBorders('input[name=dCellPhone]', "#DD0101");
	data['isValid']['Address']						? true : PutBorders('textarea[name=dAddress]', "#DD0101");
}
function PutSuccess(data) {
	!data['hasChanged']['Name']							? true : PutBorders('input[name=dName]', "#0DDD01");
	!data['hasChanged']['DesignationMetaCode']			? true : PutBorders('input[name=dCode]', "#0DDD01");
	!data['hasChanged']['DesignationMetaTitle']			? true : PutBorders('input[name=dDesignationMetaStaff]', "#0DDD01");
	!data['hasChanged']['DesignationMetaCourse']		? true : PutBorders('button[name=dCourse]', "#0DDD01");
	!data['hasChanged']['DesignationMetaSemester']		? true : PutBorders('button[name=dSemester]', "#0DDD01");
	!data['hasChanged']['DesignationMetaDesignation']	? true : PutBorders('input[name=dDesignationMetaFaculty]', "#0DDD01");
	!data['hasChanged']['MiscDateOfBirth']				? true : PutBorders('input[name=dDateOfBirth]', "#0DDD01");
	!data['hasChanged']['CellPhone']					? true : PutBorders('input[name=dCellPhone]', "#0DDD01");
	!data['hasChanged']['Gender']						? true : PutBorders('button[name=dGender]', "#0DDD01");
	!data['hasChanged']['Address']						? true : PutBorders('textarea[name=dAddress]', "#0DDD01");
}