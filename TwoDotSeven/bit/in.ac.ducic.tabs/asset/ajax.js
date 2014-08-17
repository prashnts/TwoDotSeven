var Utils = {
	Toggles : {
		Add : false
	},
	DataHook : function() {
		return {
			FirstName : $("input[name=FirstName]"),
			LastName : $("input[name=LastName]"),
			DisplayName : $("input[name=DisplayName]"),
			NickName : $("input[name=NickName]"),
			PrimaryEmail : $("input[name=PrimaryEmail]"),
			SecondEmail : $("input[name=SecondEmail]"),
			_AimScreenName : $("input[name=_AimScreenName]"),
			HomeAddress : $("input[name=HomeAddress]"),
			HomeAddress2 : $("input[name=HomeAddress2]"),
			HomeCity : $("input[name=HomeCity]"),
			HomeState : $("input[name=HomeState]"),
			HomeZipCode : $("input[name=HomeZipCode]"),
			HomeCountry : $("input[name=HomeCountry]"),
			HomePhone : $("input[name=HomePhone]"),
			WorkAddress : $("input[name=WorkAddress]"),
			WorkAddress2 : $("input[name=WorkAddress2]"),
			WorkCity : $("input[name=WorkCity]"),
			WorkState : $("input[name=WorkState]"),
			WorkZipCode : $("input[name=WorkZipCode]"),
			WorkCountry : $("input[name=WorkCountry]"),
			WorkPhone : $("input[name=WorkPhone]"),
			JobTitle : $("input[name=JobTitle]"),
			Department : $("input[name=Department]"),
			Company : $("input[name=Company]"),
			CellularNumber : $("input[name=CellularNumber]"),
			FaxNumber : $("input[name=FaxNumber]")
		}
	},
	DisableAll : function(Arrows) {
		if (!Arrows) Arrows = Utils.DataHook();
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					Arrows[key].attr("disabled", "");
					console.log("Disabled: "+key);
				}
				catch(e) {
					console.log(e);
				}
			});
		} catch(e) {
			console.log("Recovered Fatal Error "+e);
		}
	},
	EnableAll : function(Arrows) {
		if (!Arrows) Arrows = Utils.DataHook();
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					Arrows[key].removeAttr("disabled");
					console.log("Enabled: "+key);
				}
				catch(e) {
					console.log(e);
				}
			});
		} catch(e) {
			console.log("Recovered Fatal Error "+e);
		}
	},
	ClearAllFields : function(Arrows) {
		if (!Arrows) Arrows = Utils.DataHook();
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					Arrows[key].val("Clearing Field.");
					setTimeout(function() {
						Arrows[key].val("Clearing Field..");
						console.log("Cleared: "+key);
					}, 500);
					setTimeout(function() {
						Arrows[key].val("Clearing Field...");
						console.log("Cleared: "+key);
					}, 1000);
					setTimeout(function() {
						Arrows[key].val("Cleared");
						console.log("Cleared: "+key);
					}, 1500);
					setTimeout(function() {
						Arrows[key].val("");
						console.log("Cleared: "+key);
					}, 2500);
				}
				catch(e) {
					console.log(e);
				}
			});
		} catch(e) {
			console.log("Recovered Fatal Error "+e);
		}
	},
	GetData : function(Arrows) {
		if (!Arrows) Arrows = Utils.DataHook();
		RetObj = {};
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					RetObj[key] = Arrows[key].val();
				}
				catch(e) {
					console.log(e);
				}
			});
		} catch(e) {
			console.log("Recovered Fatal Error "+e);
		}
		return RetObj;
	},
	ModalButtons : {
		Dismiss : function(Action) {
			if (Action) {
				//Disable Dismiss Calls.
				$("#ModalDismiss1").attr("disabled", "");
				$("#ModalDismiss2").attr("disabled", "");
			}
			else {
				$("#ModalDismiss1").removeAttr("disabled");
				$("#ModalDismiss2").removeAttr("disabled");
			}
		},
		Action : function(Status, Color, Spin) {
			Hook = $("#ModalAction");
			if (!Status) {
				// Reset the button.
				Utils.ModalButtons.Action("Add Contact to AddressBook", "green", false);
				return Hook;
			}
			if (Color) {
				Hook.removeClass('btn-success btn-primary btn-warning btn-default btn-danger');
				Hook.addClass(function() {
					if (Color == 'red') return 'btn-danger';
					if (Color == 'green') return 'btn-success';
					if (Color == 'yellow') return 'btn-warning';
					if (Color == 'blue') return 'btn-primary';
					if (Color == 'white') return 'btn-default';
				}());
			}
			if (Spin)
				Hook.html('<i class="fa fa-circle-o-notch fa-spin"></i> '+Status);
			else
				Hook.html(Status);
			return Hook;
		}
	},
	ValidateData : function() {
		if (($("input[name=FirstName]").val().length < 1) ||
			($("input[name=PrimaryEmail]").val().length < 1)) {
			return false;
		}
		else return true;
	},
	AddIntoAb : function() {
		$.ajax({
			type: 'POST',
			url: "/dev/bit/in.ac.ducic.tabs/addIntoAddressBook",
			timeout: 30000,
			data: Utils.GetData(),
			beforeSend: function() {
				Utils.Toggles.Add = true;
				Utils.ModalButtons.Dismiss(true);
				Utils.DisableAll();
				Utils.ModalButtons.Action("Please Wait. Waiting for Response.", "blue", true);
				$('*').css('cursor','wait');
			},
			success: function(Response) {
				Utils.Toggles.Add = false;
				Utils.ModalButtons.Dismiss(false);
				Utils.ModalButtons.Action("Contact Added to the AddressBook", "green", false);
				setTimeout(function(){
					Utils.ClearAllFields();
					Utils.ModalButtons.Action();
					Utils.EnableAll();
				}, 3000)
				$('*').css('cursor','');
			},
			error: function(data) {
				Utils.Toggles.Add = false;
				Utils.ModalButtons.Dismiss(false);
				Utils.ModalButtons.Action("Some Unknown Error Occured.", "red", false);
				Utils.EnableAll();
				setTimeout(function(){
					Utils.ModalButtons.Action();
				}, 5000)
				$('*').css('cursor','');
			}
		});
	}
};

var inAction = false;
function InitClick() {
	if (Utils.Toggles.Add) {
		return;
	}
	if (!Utils.ValidateData()) {
		Utils.ModalButtons.Action("Please Fill out the Required Fields.", "red");
		setTimeout(function() {
			Utils.ModalButtons.Action();
		}, 3000);
		return;
	}
	Utils.AddIntoAb();
}