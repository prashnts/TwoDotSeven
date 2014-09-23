var BroadcastSvc = {
    HOOKID : "broadcast-container",
    BtnLoadHook: "broadcast-load-post",
    PREURI : "/dev/broadcast/feed/pre/",
    POSTURI : "/dev/broadcast/feed/post/",
    POSTFIX : false,
    PREFIX : false,
    ActionToggle : false,
    getHook : function() {
        return $("#"+this.HOOKID);
    },
    getPOSTFIX : function() {
        _Candidate = Number($(".broadcast-card:last").attr("data-timestamp"));
        if (_Candidate) return _Candidate;
        else return 0;
    },
    getPREFIX : function() {
        _Candidate = Number($(".broadcast-card:first").attr("data-timestamp"));
        if (_Candidate) return _Candidate;
        else return 0;
    },
    preFetch : function() {
        if (BroadcastSvc.ActionToggle) return;
        BroadcastSvc.ActionToggle = true;
        $.getJSON(BroadcastSvc.PREURI+BroadcastSvc.getPREFIX(), function(data) {
            BroadcastSvc.prependIntoHook(data);
            //BroadcastSvc.ActionToggle = false;
        });
    },
    postFetch : function() {
        if (BroadcastSvc.ActionToggle) return;
        console.log("EXECUTED");
        BroadcastSvc.ActionToggle = true;
        $.getJSON(BroadcastSvc.POSTURI+BroadcastSvc.getPOSTFIX(), function(data) {
            BroadcastSvc.appendIntoHook(data);
            //BroadcastSvc.ActionToggle = false;
        });
    },
    prependIntoHook : function(data) {
        if (data.length == 0) BroadcastSvc.ActionToggle = false;
        for (var i = data.length - 1; i >= 0; i--) {
            var feed = BroadcastSvc.createPost(data[i]);
            $(feed).hide().prependTo("#"+BroadcastSvc.HOOKID).delay(90*i).slideDown(100);
            if (i == 0) BroadcastSvc.ActionToggle = false;
        };
    },
    appendIntoHook : function(data) {
        if (data.length == 0) {
            BroadcastSvc.ActionToggle = false;
            $("#"+BroadcastSvc.BtnLoadHook).html('<i class="fa fa-times-circle"></i> No More Posts.');
            $("#"+BroadcastSvc.BtnLoadHook).attr('disabled', 'true');
        }
        for (var i = 0; i < data.length; i++) {
            var feed = BroadcastSvc.createPost(data[i]);
            //console.log(data);
            $(feed).hide().appendTo("#"+BroadcastSvc.HOOKID).delay(90*i).slideDown(100);
            if (data.length-1 == i) BroadcastSvc.ActionToggle = false;
        };
    },
    createPost : function(data) {
        var _echo = function(data) {
            if (data) return data;
            else return "";
        }
        var _Post = "";
        //console.log(data);
        _Post +=    '<li class="broadcast-card broadcast-default" id="BROADCAST_'+data.ID+'" data-timestamp="'+data.Timestamp+'">';
        _Post +=        '<a href="'+data.Meta.OP.URI+'" class="thumb pull-left m-r-sm">';
        _Post +=            '<img src="'+data.Meta.OP.ProfilePicture+'" class="img-circle b-a b-3x b-white">';
        _Post +=        '</a>';
        _Post +=        '<div class="clear">';
        _Post +=            '<a href="'+data.Meta.OP.URI+'">';
        _Post +=                '<span class="text-dark h4">'+_echo(data.Meta.OP.FirstName)+' '+_echo(data.Meta.OP.LastName)+' </span>';
        _Post +=                '<span class="h5">';
        _Post +=                    '@'+data.Meta.OP.UserName+' ';
        _Post +=                    '&bullet; ';
        _Post +=                '</span>';
        _Post +=                '<span class="h5">';
        _Post +=                    data.TargetType+' ';
        for (var i = 0; i < data.Meta.TaggedUsers.length; i++) {
        _Post +=                    '<a href="'+data.Meta.TaggedUsers[i].URI+'" class="label bg-primary">'+data.Meta.TaggedUsers[i].UserName+'</a> ';
        };
        _Post +=                '</span>';
        _Post +=                '<br>'
        _Post +=                '<span class="h6 text-muted">';
        _Post +=                    'Posted <span class="elapsedJS" data-elapseJS="'+data.Timestamp+'"></span>';
        _Post +=                    ' &bullet; ';
        _Post +=                    '<i class="fa '+data.VisibleClass+'"></i>';
        _Post +=                '</span>';
        _Post +=            '</a>';
        _Post +=            '<hr class="m-t-xs m-b-xs">';
        _Post +=            '<p>'+data.Data+'</p>';
        _Post +=        '</div>';
        _Post +=        '<div class="broadcast-card-actions">';
        _Post +=        '</div>';
        _Post +=    '</li>';

        return _Post;
    },
    init: function() {
        $.ajaxSetup ({
            cache: false
        });
        window.setInterval(function() {
            BroadcastSvc.preFetch();
        }, 5000);
        $('#broadcast').scroll(function() {
            if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
                BroadcastSvc.postFetch();
                console.log("FIRED TOP!");
            }
        })
        window.onscroll = function() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight-10) {
                BroadcastSvc.postFetch();
                console.log("FIRED!");
            }
        };
        $("#"+BroadcastSvc.BtnLoadHook).click(function() {
            BroadcastSvc.postFetch();
        });
    }
};

var BroadcastPushSvc = {
    TextboxHook: "broadcast-post-area",
    BtnHook: "broadcast-post-btn",
    POSTURI: "/dev/broadcast/post",
    ActionToggle: false,
    POST: function() {
        var BroadcastText = $("#"+this.TextboxHook).val();
        if (BroadcastText.length < 2) return;
        $.ajax({
            type: 'POST',
            url: this.POSTURI,
            timeout: 30000,
            data: {
                BroadcastText: BroadcastText
            },
            beforeSend: function() {
                this.ButtonMsg("Posting");
            },
            success: function() {
                this.ButtonMsg("Done!");
            },
            error: function(data) {
                this.ButtonMsg("Whoops");
            }
        });
    },
    BroadcastAreaInit: function() {
        _hook = this.TextboxHook;
        $("#"+this.BtnHook).slideDown();
        $("#"+_hook).addClass("active");
    },
    BroadcastAreaDeInit: function() {
        _hook = this.TextboxHook;
        $("#"+_hook).removeClass("active");
        $("#"+_hook).val("");
        $("#"+this.BtnHook).slideUp()
        setTimeout(function() {
            BroadcastPushSvc.BroadcastButtonMessage(5);
        }, 500); 
    },
    BroadcastDisable: function() {
        $("#"+this.TextboxHook).attr("disabled", "true");
        $("#"+this.BtnHook).attr("disabled", "true");
    },
    BroadcastEnable: function() {
        $("#"+this.TextboxHook).removeAttr("disabled");
        $("#"+this.BtnHook).removeAttr("disabled");
    },
    BroadcastButtonMessage: function (ID) {
        $("#"+this.BtnHook).removeClass("btn-primary btn-success btn-danger");
        switch (ID) {
            case 1:
                $("#"+this.BtnHook).addClass("btn-primary");
                $("#"+this.BtnHook).html('<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;Processing');
                break;
            case 2:
                $("#"+this.BtnHook).addClass("btn-success");
                $("#"+this.BtnHook).html('<i class="fa fa-check-circle"></i>&nbsp;Posted');
                break;
            case 3:
                $("#"+this.BtnHook).addClass("btn-danger");
                $("#"+this.BtnHook).html('<i class="fa fa-times-circle"></i>&nbsp;Error Processing Request');
                break;
            case 4:
                $("#"+this.BtnHook).addClass("btn-danger");
                $("#"+this.BtnHook).html('<i class="fa fa-times-circle"></i>&nbsp;Please Post Something');
                break;
            case 5:
                $("#"+this.BtnHook).addClass("btn-success");
                $("#"+this.BtnHook).html('Broadcast to Everyone');
                break;
            case 6:
            default:
                $("#"+this.BtnHook).addClass("btn-success");
                $("#"+this.BtnHook).html('Broadcast to These People');
                break;
        }
    },
    Broadcast: function() {
        if (BroadcastPushSvc.ActionToggle) return;
        var BroadcastText = $("#"+this.TextboxHook).val();
        if (BroadcastText.length < 2) {
            this.BroadcastButtonMessage(4);
            setTimeout(function() {
                BroadcastPushSvc.BroadcastButtonMessage(5);
            }, 2000);
            return;
        }
        //return;
        $.ajax({
            type: 'POST',
            url: BroadcastPushSvc.POSTURI,
            timeout: 30000,
            data: {
                BroadcastText: BroadcastText
            },
            beforeSend: function() {
                BroadcastPushSvc.BroadcastButtonMessage(1);
                BroadcastPushSvc.BroadcastDisable();
                BroadcastPushSvc.ActionToggle = true;
            },
            success: function() {
                BroadcastPushSvc.BroadcastButtonMessage(2);
                BroadcastSvc.preFetch();
                setTimeout(function() {
                    BroadcastPushSvc.BroadcastAreaDeInit();
                    BroadcastPushSvc.BroadcastEnable();
                }, 2000);
                BroadcastPushSvc.ActionToggle = false;
            },
            error: function(data) {
                BroadcastPushSvc.BroadcastEnable();
                BroadcastPushSvc.BroadcastButtonMessage(1);
                BroadcastPushSvc.ActionToggle = false;
            }
        });
    },
    init: function() {
        $("#"+this.BtnHook).click(function() {
            BroadcastPushSvc.Broadcast();
        });

        $("#"+this.TextboxHook).click(function(){
            BroadcastPushSvc.BroadcastAreaInit();
        });
    }
};

var Elapsed = {

    /**
     * Package initiator.
     */
    ClassHook: "elapsedJS",

    /**
     * HTML5 Standard data container.
     */
    DataHook: "data-elapseJS",

    /**
     * Prevents Multiple runtimes.
     */
    ActionToggle: false,

    /**
     * Time interval between routine calls. See Routine.
     */
    RoutineInterval: 1000,

    /**
     * Enables Debugging Mode.
     */
    ElapsedDEBUG: false,

    /**
     * Main Action. Iterates through ALL elapse elements and converts them into Elapse Objects.
     * @param: none.
     * @return: none.
     */
    action: function() {
        if(Elapsed.ActionToggle) {
            Elapsed.debugMsg("ElapsedJS action is Locked.");
            return;
        }

        Elapses = document.getElementsByClassName(Elapsed.ClassHook);
        
        for (var i = 0; i < Elapses.length; i++) {
            if (i == 0) {
                Elapsed.ActionToggle = true;
                Elapsed.debugMsg("Locked ElapsedJS action.");
            }
            
            var Elapse = Elapses[i];
            try {
                var pastTime = parseInt(Elapse.getAttribute(Elapsed.DataHook));
                var past = new Date(pastTime*1000);

                var now = new Date();
                var timeNow = parseInt(now.getTime()/1000);

                var ago = timeNow - pastTime;

                putTime = function(message) {
                    Elapse.innerHTML = message;
                };

                if (ago < 60) putTime("just now");
                else if (ago < 120) putTime("a few minutes ago");
                else if (ago < 3570) putTime(parseInt(ago/60)+" minutes ago");
                else if (ago < 86400) putTime("today, at "+Elapsed.formatDate(past, "h:mmTT"));
                else if (ago < 172800) putTime("yesterday, at "+Elapsed.formatDate(past, "h:mmTT"));
                else putTime(Elapsed.formatDate(past, "h:mmTT, d MMMM yyyy"));

            } catch (E) {
                Elapsed.debugMsg(E.message);
            }

            if (i == Elapses.length-1) {
                Elapsed.ActionToggle = false;
                Elapsed.debugMsg("Unlocked ElapsedJS action.");
            }
        }
    },

    /**
     * Returns the Prettified Date, according to given .NET style date-time format. 
     * @param: date Date Object, Required. Date Object.
     * @param: format String, Required. .NET Style date-time format.
     * @param: utc Integer, Optional. Optional UTC offset. Default- System default.
     * @return: string. The Date-Time formatted string.
     */
    formatDate: function(date, format, utc) {
        var MMMM = ["\x00", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var MMM = ["\x01", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var dddd = ["\x02", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var ddd = ["\x03", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        function ii(i, len) {
            var s = i + "";
            len = len || 2;
            while (s.length < len) s = "0" + s;
            return s;
        }

        var y = utc ? date.getUTCFullYear() : date.getFullYear();
        format = format.replace(/(^|[^\\])yyyy+/g, "$1" + y);
        format = format.replace(/(^|[^\\])yy/g, "$1" + y.toString().substr(2, 2));
        format = format.replace(/(^|[^\\])y/g, "$1" + y);

        var M = (utc ? date.getUTCMonth() : date.getMonth()) + 1;
        format = format.replace(/(^|[^\\])MMMM+/g, "$1" + MMMM[0]);
        format = format.replace(/(^|[^\\])MMM/g, "$1" + MMM[0]);
        format = format.replace(/(^|[^\\])MM/g, "$1" + ii(M));
        format = format.replace(/(^|[^\\])M/g, "$1" + M);

        var d = utc ? date.getUTCDate() : date.getDate();
        format = format.replace(/(^|[^\\])dddd+/g, "$1" + dddd[0]);
        format = format.replace(/(^|[^\\])ddd/g, "$1" + ddd[0]);
        format = format.replace(/(^|[^\\])dd/g, "$1" + ii(d));
        format = format.replace(/(^|[^\\])d/g, "$1" + d);

        var H = utc ? date.getUTCHours() : date.getHours();
        format = format.replace(/(^|[^\\])HH+/g, "$1" + ii(H));
        format = format.replace(/(^|[^\\])H/g, "$1" + H);

        var h = H > 12 ? H - 12 : H == 0 ? 12 : H;
        format = format.replace(/(^|[^\\])hh+/g, "$1" + ii(h));
        format = format.replace(/(^|[^\\])h/g, "$1" + h);

        var m = utc ? date.getUTCMinutes() : date.getMinutes();
        format = format.replace(/(^|[^\\])mm+/g, "$1" + ii(m));
        format = format.replace(/(^|[^\\])m/g, "$1" + m);

        var s = utc ? date.getUTCSeconds() : date.getSeconds();
        format = format.replace(/(^|[^\\])ss+/g, "$1" + ii(s));
        format = format.replace(/(^|[^\\])s/g, "$1" + s);

        var f = utc ? date.getUTCMilliseconds() : date.getMilliseconds();
        format = format.replace(/(^|[^\\])fff+/g, "$1" + ii(f, 3));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])ff/g, "$1" + ii(f));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])f/g, "$1" + f);

        var T = H < 12 ? "AM" : "PM";
        format = format.replace(/(^|[^\\])TT+/g, "$1" + T);
        format = format.replace(/(^|[^\\])T/g, "$1" + T.charAt(0));

        var t = T.toLowerCase();
        format = format.replace(/(^|[^\\])tt+/g, "$1" + t);
        format = format.replace(/(^|[^\\])t/g, "$1" + t.charAt(0));

        var tz = -date.getTimezoneOffset();
        var K = utc || !tz ? "Z" : tz > 0 ? "+" : "-";
        if (!utc) {
            tz = Math.abs(tz);
            var tzHrs = Math.floor(tz / 60);
            var tzMin = tz % 60;
            K += ii(tzHrs) + ":" + ii(tzMin);
        }
        format = format.replace(/(^|[^\\])K/g, "$1" + K);

        var day = (utc ? date.getUTCDay() : date.getDay()) + 1;
        format = format.replace(new RegExp(dddd[0], "g"), dddd[day]);
        format = format.replace(new RegExp(ddd[0], "g"), ddd[day]);

        format = format.replace(new RegExp(MMMM[0], "g"), MMMM[M]);
        format = format.replace(new RegExp(MMM[0], "g"), MMM[M]);

        format = format.replace(/\\(.)/g, "$1");

        return format;
    },

    /**
     * If ElapsedDEBUG is true, logs all the Debug data to the console.
     * @param: message, String Required. The Message.
     * @return: none.
     */
    debugMsg: function(message) {
        if (Elapsed.ElapsedDEBUG) {
            console.log("ElapsedJS DEBUG: "+message);
        }
    },

    /**
     * Starts the Elapsed Job, and inits the Routine Job.
     * @param: none.
     * @return: none.
     */
    init: function() {
        Elapsed.action();
        Elapsed.routine();
        Elapsed.debugMsg("Initialized ElapsedJS.");
    },

    /**
     * Repeats the Action depending on RoutineInterval.
     * @param: none.
     * @return: none.
     */
    routine: function() {
        window.setInterval(function() {
            Elapsed.debugMsg("Routine Called.");
            Elapsed.action();
        }, Elapsed.RoutineInterval);
    }
};

var Cookie = {
    create: function(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    },
    read: function(name) {
        var nameEQ = escape(name) + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
        }
        return null;
    },
    erase: function(name) {
        Cookie.create(name, "", -1);
    }
};

var ProfileUpdate = {
    SaveHook: "profile-update-save",
    SaveBtmHook: "profile-update-save-btm",
    PostURI: "/dev/user/"+Cookie.read("Two_7User")+"/updateMeta/",

    FirstNameToggle: false,
    FirstName: function() {
        if (ProfileUpdate.FirstNameToggle) return;
        var Hook = $("#Profile-FirstName");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"FirstName",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.FirstNameToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.FirstNameToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
                console.log(data);
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.FirstNameToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    LastNameToggle: false,
    LastName: function() {
        if (ProfileUpdate.LastNameToggle) return;
        var Hook = $("#Profile-LastName");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"LastName",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.LastNameToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.LastNameToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.LastNameToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    DesignationToggle: false,
    Designation: function() {
        if (ProfileUpdate.DesignationToggle) return;
        var Hook = $("#Profile-Designation");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Designation",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.DesignationToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.DesignationToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.DesignationToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    CourseToggle: false,
    Course: function() {
        if (ProfileUpdate.CourseToggle) return;
        var Hook = $("#Profile-Course");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Course",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.CourseToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.CourseToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.CourseToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    YearToggle: false,
    Year: function() {
        if (ProfileUpdate.YearToggle) return;
        var Hook = $("#Profile-Year");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Year",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.YearToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.YearToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.YearToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    BioToggle: false,
    Bio: function() {
        if (ProfileUpdate.BioToggle) return;
        var Hook = $("#Profile-Bio");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Bio",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.BioToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.BioToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.BioToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    MobileToggle: false,
    Mobile: function() {
        if (ProfileUpdate.MobileToggle) return;
        var Hook = $("#Profile-Mobile");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Mobile",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.MobileToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.MobileToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.MobileToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    RollNumberToggle: false,
    RollNumber: function() {
        if (ProfileUpdate.RollNumberToggle) return;
        var Hook = $("#Profile-RollNumber");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"RollNumber",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.RollNumberToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.RollNumberToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.RollNumberToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    GenderToggle: false,
    Gender: function() {
        if (ProfileUpdate.GenderToggle) return;
        var Hook = $("#Profile-Gender");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Gender",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.GenderToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.GenderToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.GenderToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    DOBToggle: false,
    DOB: function() {
        if (ProfileUpdate.DOBToggle) return;
        var Hook = $("#Profile-DOB");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"DOB",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.DOBToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.DOBToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.DOBToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },
    AddressToggle: false,
    Address: function() {
        if (ProfileUpdate.AddressToggle) return;
        var Hook = $("#Profile-Address");
        $.ajax({
            type: 'POST',
            url: this.PostURI+"Address",
            timeout: 30000,
            data: {
                ProfileUpdateValue: Hook.val()
            },
            beforeSend: function() {
                Hook.attr("disabled", "true");
                ProfileUpdate.AddressToggle = true;
                ProfileUpdate.HighlightField(Hook, "blue");
            },
            success: function() {
                Hook.removeAttr("disabled");
                ProfileUpdate.AddressToggle = false;
                ProfileUpdate.HighlightField(Hook, "green");
            },
            error: function(data) {
                Hook.removeAttr("disabled");
                ProfileUpdate.AddressToggle = false;
                ProfileUpdate.HighlightField(Hook, "red");
                console.log(data);
            }
        });
    },

    HighlightField: function(hook, status) {
        switch (status) {
            case "green":
                hook.css("border-color", "green");
                window.setTimeout(function() {
                    hook.css("border-color", "");
                }, 2500);
                break;
            case "red":
                hook.css("border-color", "red");
                window.setTimeout(function() {
                    hook.css("border-color", "");
                }, 2500);
                break;
            case "blue":
                hook.css("border-color", "blue");
                window.setTimeout(function() {
                    hook.css("border-color", "");
                }, 2500);
                break;
            default:
                hook.css("border-color", "");
        }
    },
    SaveStatusToggle: false,
    SaveStatus: function(status) {
        if (this.SaveStatusToggle == status) return;
        else this.SaveStatusToggle = status;
        switch(status) {
            case "saving":
                $("#"+ProfileUpdate.SaveHook).html('<i class="fa fa-circle-o-notch fa-spin"></i> Saving');
                $("#"+ProfileUpdate.SaveHook).attr("disabled", "true");
                $("#"+ProfileUpdate.SaveHook).removeClass("btn-primary btn-success btn-danger");
                $("#"+ProfileUpdate.SaveHook).addClass("btn-primary");
                $("#"+ProfileUpdate.SaveBtmHook).html('<i class="fa fa-circle-o-notch fa-spin"></i> Saving');
                $("#"+ProfileUpdate.SaveBtmHook).attr("disabled", "true");
                $("#"+ProfileUpdate.SaveBtmHook).removeClass("btn-primary btn-success btn-danger");
                $("#"+ProfileUpdate.SaveBtmHook).addClass("btn-primary");
                break;
            case "default":
            default:
                $("#"+ProfileUpdate.SaveHook).html('<i class="fa fa-globe"></i> Save Changes');
                $("#"+ProfileUpdate.SaveHook).removeAttr("disabled");
                $("#"+ProfileUpdate.SaveHook).removeClass("btn-primary btn-success btn-danger");
                $("#"+ProfileUpdate.SaveHook).addClass("btn-success");
                $("#"+ProfileUpdate.SaveBtmHook).html('<i class="fa fa-globe"></i> Save Changes');
                $("#"+ProfileUpdate.SaveBtmHook).removeAttr("disabled");
                $("#"+ProfileUpdate.SaveBtmHook).removeClass("btn-primary btn-success btn-danger");
                $("#"+ProfileUpdate.SaveBtmHook).addClass("btn-success");
        }
    },
    SaveListenerToggle: false,
    SaveListener: function() {
        _Aggregate =
                this.FirstNameToggle ||
            this.LastNameToggle ||
            this.DesignationToggle ||
            this.CourseToggle ||
            this.YearToggle ||
            this.BioToggle ||
            this.MobileToggle ||
            this.RollNumberToggle ||
            this.GenderToggle ||
            this.DOBToggle ||
            this.AddressToggle;

        if (_Aggregate) this.SaveStatus("saving");
        else this.SaveStatus("defaultS");
    },
    init: function() {
        window.setInterval(function() {
            ProfileUpdate.SaveListener();
        }, 250);
    }
};

BroadcastSvc.postFetch();
BroadcastSvc.init();
BroadcastPushSvc.init();
Elapsed.init();
ProfileUpdate.init();