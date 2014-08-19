var Utils = {
	Toggles : {
		AddUpdate : false,
		Delete: false,
		DeleteIDCache: false,
		DeleteProceed: false,
		IDNum: false
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
	ClearAllFields : function(Arrows, Data) {
		if (!Arrows) Arrows = Utils.DataHook();
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					Arrows[key].val(Data ? Data : "");
					console.log("Cleared: "+key);
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
	PutData : function(Arrows, Data) {
		if (!Arrows) Arrows = Utils.DataHook();
		RetObj = {};
		try {
			Object.keys(Arrows).forEach(function (key) {
				try {
					RetObj[key] = Arrows[key].val(Data[key]);
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
				if (Utils.ActionCall == "Add") Utils.ModalButtons.Action("Add Contact to AddressBook", "green", false);
				else if (Utils.ActionCall == "Update") Utils.ModalButtons.Action("Update Contact in AddressBook", "green", false);
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
	ModalMode: {
		Add: function() {
			$(".ModalAdd").show();
			$("#ModalTitle").html("Add Contact");
			Utils.ModalButtons.Action("Add Contact to AddressBook", "green", false);
			Utils.EnableAll();
			Utils.ClearAllFields();
		},
		Update: function() {
			$(".ModalAdd").show();
			$("#ModalTitle").html("Update Contact");
			Utils.ModalButtons.Action("Update Contact in AddressBook", "green", false);
			Utils.EnableAll();
			Utils.ClearAllFields();
		},
		View: function() {
			$(".ModalAdd").hide();
			$("#ModalTitle").html("Contact Details");
			Utils.DisableAll();
			Utils.ClearAllFields(false, "Loading");
		},
	},
	Modal: $("#Modal"),
	Masonry: $("#contains"),
	ActionCall: false,
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
				Utils.Toggles.AddUpdate = true;
				Utils.ModalButtons.Dismiss(true);
				Utils.DisableAll();
				Utils.ModalButtons.Action("Please Wait. Waiting for Response.", "blue", true);
				$('*').css('cursor','wait');
			},
			success: function(Response) {
				Utils.Toggles.AddUpdate = false;
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
				Utils.Toggles.AddUpdate = false;
				Utils.ModalButtons.Dismiss(false);
				Utils.ModalButtons.Action("Some Unknown Error Occured.", "red", false);
				Utils.EnableAll();
				setTimeout(function(){
					Utils.ModalButtons.Action();
				}, 5000)
				$('*').css('cursor','');
			}
		});
	},
	GetMoreDetails : function(ID, Callback) {
		URI = "/dev/bit/in.ac.ducic.tabs/getCardByID?ID="+ID;
		Utils.Modal.modal("show");
		Utils.ModalMode.View();
		$.getJSON(
			URI,
			"",
			function(data) {
				Utils.PutData(false, data);
				Callback ? Callback(data) : false;
			});
	},
	DeleteCard: function(ID) {
		if (Utils.Toggles.Delete) {
			return;
		}

		if (Utils.Toggles.DeleteIDCache && Utils.Toggles.DeleteIDCache != ID) {
			Utils.Toggles.DeleteProceed = false;
		}

		if (!Utils.Toggles.DeleteProceed) {
			Utils.Toggles.Delete = true;
			$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
			$("#"+ID).addClass("btn-primary");
			$("#"+ID).html('Please Wait 3 <i class="fa fa-circle-o-notch fa-spin"></i>');
			setTimeout(function(){
				$("#"+ID).html('Please Wait 2 <i class="fa fa-circle-o-notch fa-spin"></i>');
			}, 1000);
			setTimeout(function(){
				$("#"+ID).html('Please Wait 1 <i class="fa fa-circle-o-notch fa-spin"></i>');
			}, 2000);
			setTimeout(function(){
				$("#"+ID).html('Please Wait 0 <i class="fa fa-circle-o-notch fa-spin"></i>');
			}, 3000);
			setTimeout(function(){
				$("#"+ID).html('Click Here to Delete');
				$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
				$("#"+ID).addClass("btn-danger");
				Utils.Toggles.Delete = false;
				Utils.Toggles.DeleteIDCache = ID;
				Utils.Toggles.DeleteProceed = true;
			}, 3000);

			return;
		}

		$.ajax({
			type: 'POST',
			url: '/dev/bit/in.ac.ducic.tabs/deleteCardByID',
			timeout: 30000,
			data: {
				ID: $("#"+ID).attr("data-tabs-id")
			},
			beforeSend: function() {
				Utils.Toggles.Delete = true;
				$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
				$("#"+ID).addClass("btn-primary");
				$("#"+ID).html('Deleting <i class="fa fa-circle-o-notch fa-spin"></i>');
			},
			success: function() {
				$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
				$("#"+ID).addClass("btn-success");
				$("#"+ID).html('Please Wait.');
				setTimeout(function() {
					Utils.Toggles.Delete = false;
					Utils.Toggles.DeleteProceed = false;
					Utils.Toggles.DeleteIDCache = false;
					Utils.Masonry.masonry("remove", $("#CardData-"+$("#"+ID).attr("data-tabs-id")));
					Utils.Masonry.masonry()
				}, 500);
			},
			error: function(data) {
				$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
				$("#"+ID).addClass("btn-danger");
				$("#"+ID).html('Error while Deleting.');
				setTimeout(function() {
					$("#"+ID).html('Please Retry.');
					Utils.Toggles.Delete = false;
					Utils.Toggles.DeleteProceed = false;
					Utils.Toggles.DeleteIDCache = false;
					setTimeout(function() {
						$("#"+ID).removeClass("btn-danger btn-default btn-primary btn-warning btn-success");
						$("#"+ID).addClass("btn-default");
						$("#"+ID).html('Delete');
					}, 2000);
				}, 3000);
			}
		});
	},
	UpdateCard: function(ID) {
		var Data = Utils.GetData();
		Data.ID = Utils.Toggles.IDNum;
		$.ajax({
			type: 'POST',
			url: "/dev/bit/in.ac.ducic.tabs/updateCardByID",
			timeout: 30000,
			data: Data,
			beforeSend: function() {
				Utils.Toggles.AddUpdate = true;
				Utils.ModalButtons.Dismiss(true);
				Utils.DisableAll();
				Utils.ModalButtons.Action("Please Wait. Waiting for Response.", "blue", true);
				$('*').css('cursor','wait');
			},
			success: function(Response) {
				Utils.Toggles.AddUpdate = false;
				Utils.ModalButtons.Dismiss(false);
				Utils.ModalButtons.Action("Contact Updated Successfully.", "green", false);
				setTimeout(function(){
					Utils.ClearAllFields();
					Utils.ModalButtons.Action();
					Utils.EnableAll();
				}, 3000)
				$('*').css('cursor','');
			},
			error: function(data) {
				Utils.Toggles.AddUpdate = false;
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

function InitClick() {
	if (Utils.Toggles.AddUpdate) {
		return;
	}
	if (!Utils.ValidateData()) {
		Utils.ModalButtons.Action("Please Fill out the Required Fields.", "red");
		setTimeout(function() {
			Utils.ModalButtons.Action();
		}, 3000);
		return;
	}
	if (Utils.ActionCall == "Update") Utils.UpdateCard();
	else if (Utils.ActionCall == "Add") Utils.AddIntoAb();
	else return;
}

function ModalShowAddWindow() {
	Utils.ModalMode.Add();
	Utils.ActionCall = "Add";
	Utils.Modal.modal("show");
}

function ModalShowUpdateWindow(ID) {
	var IDNum = $("#"+ID).attr("data-tabs-id");
	Utils.Toggles.IDNum = IDNum;
	Utils.ActionCall = "Update";
	Utils.GetMoreDetails(IDNum, function(data) {
		Utils.ModalMode.Update();
		//console.log(data);
		Utils.PutData(false, data);
	});
}