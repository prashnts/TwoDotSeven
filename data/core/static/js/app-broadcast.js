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
        _Candidate = Number($("#broadcast-container li:last").attr("data-timestamp"));
        if (_Candidate) return _Candidate;
        else return 0;
    },
    getPREFIX : function() {
        _Candidate = Number($("#broadcast-container li:first").attr("data-timestamp"));
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
            $(feed).hide().appendTo("#"+BroadcastSvc.HOOKID).delay(90*i).slideDown(100);
            if (data.length-1 == i) BroadcastSvc.ActionToggle = false;
        };
    },
    createPost : function(data) {
        var _Post = "";
        //console.log(data);
        _Post +=    '<li class="broadcast-card broadcast-default" id="BROADCAST_'+data.ID+'" data-timestamp="'+data.Timestamp+'">';
        _Post +=        '<a href="'+data.Meta.OP.URI+'" class="thumb pull-left m-r-sm">';
        _Post +=            '<img src="'+data.Meta.OP.IMG+'" class="img-circle b-a b-3x b-white">';
        _Post +=        '</a>';
        _Post +=        '<div class="clear">';
        _Post +=            '<a href="'+data.Meta.OP.URI+'">';
        _Post +=                '<span class="text-dark h4">'+data.Meta.OP.Name+' </span>';
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
        _Post +=                    'Posted '+data.TimeAgo;
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
            }
        })
        window.onscroll = function() {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight-10) {
                BroadcastSvc.postFetch();
            }
        };
        $("#"+BroadcastSvc.BtnLoadHook).click(function() {
            BroadcastSvc.postFetch();
        });
    }
}

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
}

BroadcastSvc.postFetch();
BroadcastSvc.init();
BroadcastPushSvc.init();