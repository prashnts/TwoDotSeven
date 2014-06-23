function AJAXRegister(Value,Field,ClassID,Args,Table) {

	// -Arguments:	Value:		Important. Value Contained in the Field
	//				Field:		Important. Field Name to be checked in the Database.
	//				ClassID: 	Important. Changes the Class Name.
	//				Args: 		Optional. Specify Return Type.	
	// -Usage:		Used to Verify the Inputs by User. Throws No Exception. Server Side Validation is Required.
	// -Author:		Prashant Sinha (PrashantSinha@outlook.com)
	// -Committed:	03/02/2014
	// -Logging:	None.

	if (Value.length==0) {
		document.getElementById(ClassID).className="form-group input-group has-warning";
		document.getElementById(ClassID+"-fa").className="fa fa-exclamation-triangle";
		return;
	}

	if(!fGetPattern(Field).test(Value)) {
		document.getElementById(ClassID).className="form-group input-group has-warning";
		document.getElementById(ClassID+"-fa").className="fa fa-exclamation-triangle";
		return;
	}

	var AJAX= new XMLHttpRequest();
	AJAX.onreadystatechange=function() {
		if (AJAX.readyState<4) {
			document.getElementById(ClassID).className="form-group input-group has-warning";
			document.getElementById(ClassID+"-fa").className="fa fa-spinner fa-spin";
		}
		if (AJAX.readyState==4) {
			console.log(AJAX.responseText);
			if (AJAX.status==200) {
				if(AJAX.responseText=="NOPE") {
					document.getElementById(ClassID).className="form-group input-group has-error";
					document.getElementById(ClassID+"-fa").className="fa fa-times-circle";
				}
				if(AJAX.responseText=="OK") {
					document.getElementById(ClassID).className="form-group input-group has-success";
					document.getElementById(ClassID+"-fa").className="fa fa-check-circle";
				}
			}
			else {
				document.getElementById(ClassID).className="form-group input-group has-error";
				document.getElementById(ClassID+"-fa").className="fa fa-exclamation-circle";
			}
		}
	}
	AJAX.open("POST","api/ajax-lib.php",true);
	AJAX.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	POSTData="Field="+Field+"&Query="+Value+"&Mode=Unique&Table="+Table;
	AJAX.send(POSTData);
}

function AJAXInventory($Arg) {

	// -Arguments:	Value:		Important. Value Contained in the Field
	//				Field:		Important. Field Name to be checked in the Database.
	// -Usage:		Used to do the Inventory Management. Authentication is Required EACH TIME A REQUEST IS MADE.
	// -Author:		Prashant Sinha (PrashantSinha@outlook.com)
	// -Committed:	10/02/2014
	// -Logging:	Done by the Response Script.
	// -Todo: 		Response Handelling.

	switch ($Arg) {
		case "Add"	: 	SKU 	= document.getElementById("SKU-F").value;
						Name 	= document.getElementById("NAME-F").value;
						Quant	= document.getElementById("QUANTITY-F").value;
						Desc	= document.getElementById("DESCRIPTION-F").value;
						Request	= "Mode=Add&SKU="+SKU+"&Name="+Name+"&Quant="+Quant+"&Desc="+Desc+"&Requested=TRUE";
						console.log(Request);
						var AJAX= new XMLHttpRequest();
						//Doing the AJAX Request now.
						AJAX.onreadystatechange=function() {
							if (AJAX.readyState<4) {
								console.log("In Process");
							}
							if (AJAX.readyState==4) {
								console.log(AJAX.responseText);
							}
						}

						AJAX.open("POST","assets/site-meta/ajax-lib.php",true);
						AJAX.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						AJAX.send(Request);
						console.log("Done: AJAX request.");
						break;
		case "Del"	:	//Pass.
						break;
		default		: 	//Pass.

	}
}

function fDoStuff($Arg, $Value) {

	// -Arguments:	Value:		Important. Value Contained in the Field
	//				Arg: 		Important. pecifies the Switch.	
	// -Usage:		Used to Verify the Inputs by User. Throws No Exception. Server Side Validation is Required.
	// -Author:		Prashant Sinha (PrashantSinha@outlook.com)
	// -Committed:	22/02/2014
	// -Logging:	None.

	switch($Arg) {
		case "SKU": 	var AJAX= new XMLHttpRequest();
						SKU=$Value;
						Request="Mode=SKU&SKUName="+SKU;
						AJAX.onreadystatechange=function() {
							if (AJAX.readyState<4) {
								document.getElementById('SKUPreview-S').className="fa fa-spinner fa-spin";
							}
							if (AJAX.readyState==4) {
								if (AJAX.status==200) {
									document.getElementById('SKUPreview-S').className="fa fa-check";
									document.getElementById('SKUPreview').innerHTML=AJAX.responseText;
								}
								else {
									document.getElementById('SKUPreview-S').className="fa fa-exclamation-triangle";
									document.getElementById('SKUPreview').innerHTML="###-####";
								}
							}
						}
						AJAX.open("POST","api/ajax-lib.php",true);
						AJAX.setRequestHeader("Content-type","application/x-www-form-urlencoded");
						AJAX.send(Request);
	}
}


function fGetPattern(Arg) {
	switch (Arg) {
		case "UserName" : return /^[a-zA-Z0-9_\- ]+$/;
		case "EMail"	: return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	}
}