var GroupGrid = {
    HOOKID: "group-grid",
    CARDHOOK: "grp-card",
    FETCHURI: "/dev/groupadmin/list",
    IDPREFIX: "group-card-",
    DONE: false,
    get: function(callback) {
        $.getJSON(this.FETCHURI)
            .done(function(data) {
                if (callback) {
                    callback(data);
                }
                GroupGrid.DONE = true;
            })
            .fail(function() {
                console.log (":(");
            });
    },
    drawCard: function(data) {
        Card  = '<div class="grp-card" id="'+GroupGrid.IDPREFIX+data.GroupID+'">\n';
        Card += '   <a href="'+data.URI+'">\n';
        Card += '        <div class="padder">\n';
        Card += '            <img src="'+data.GroupPicture+'" class="m-b">\n';
        Card += '            <p class="title">'+ū.WCF(data.Name, data.GroupID, "-")+'</p>\n';
        Card += '            <p class="subtitle">'+ū.WCF(data.DescriptionShort, "")+'</p>\n';
        Card += '            <p class="border"></p>\n';
        Card += '            <p class="preview">Open</p>\n';
        Card += '        </div>\n';
        Card += '    </a>\n';
        Card += '</div>\n';
        GroupGrid.masonry.add(Card);
    },
    drawRoutine: function(data) {
        $("#"+GroupGrid.HOOKID).html("");
        for (var i = data.length - 1; i >= 0; i--) {
            GroupGrid.drawCard(data[i]);
        };
        ū.unbindBusy();
    },
    masonry: {
        hook: function() {
            return $('#'+GroupGrid.HOOKID);
        },
        init: function() {
            GroupGrid.masonry.hook().masonry({
                columnWidth: "."+GroupGrid.CARDHOOK,
                columnHeight: "."+GroupGrid.CARDHOOK,
                itemSelector: "."+GroupGrid.CARDHOOK,
                isFitWidth: true
            });
        },
        add: function(string) {
            var Container = GroupGrid.masonry.hook();
            $(Container).prepend(string);
            $(Container).masonry('reloadItems');
            $(Container).masonry('layout');
        }
    },
    gridInit: function() {
        if (this.DONE) return;
        if (ū.IDExists(this.HOOKID)) {
            this.masonry.init();
            ū.bindBusy();
            this.get(GroupGrid.drawRoutine);
        }
    }
};

var AddGroup = {CREATEHOOK: "Cluster-Add-Panel-Create",
    CREATESUCCESSHOOK: "Cluster-Add-Panel-Success",
    ADDURI: "/dev/groupadmin/create",
    ACTIVE: false,
    HOOKS: {
        SuccessPanel: "Cluster-Add-Panel-Success",
        CreatePanel: "Cluster-Add-Panel-Create",
        ErrorPanel: "Cluster-Add-Panel-Error",
        SuccessPanelGroupID: "Cluster-Add-Panel-Success-GroupID",
        SuccessPanelURI: "Cluster-Add-Panel-Success-URI",
        SuccessPanelGoTo: "Cluster-Add-Panel-Success-GoTo",

        CreatePanelButton: "Cluster-Add-Panel-Create-Button",

        GlobalHideButton: "Cluster-Hide-Globals",
        GlobalRetryButton: "Cluster-Retry-Globals"
    },
    createRequest: function(success, error) {
        this.ACTIVE = true;
        $.getJSON(this.ADDURI)
            .done(function(data) {
                AddGroup.ACTIVE = false;
                if (success) {
                    success(data);
                }
            })
            .fail(function(data) {
                AddGroup.ACTIVE = false;
                if (error) {
                    error(data);
                }
            });
    },
    success: function(data) {
        $(ū.id(AddGroup.HOOKS.SuccessPanelGroupID)).html(ū.WCF(data.GroupID, "grpID"));
        $(ū.id(AddGroup.HOOKS.SuccessPanelURI)).html(ū.WCF(data.URI), "#");
        $(ū.id(AddGroup.HOOKS.SuccessPanelURI)).attr("href", ū.WCF(data.URI), "#");
        $(ū.id(AddGroup.HOOKS.SuccessPanelGoTo)).attr("href", ū.WCF(data.URI), "#");
        
        $(ū.id(AddGroup.HOOKS.SuccessPanel)).slideDown();
        $(ū.id(AddGroup.HOOKS.ErrorPanel)).slideUp();
        $(ū.id(AddGroup.HOOKS.CreatePanel)).slideUp();

        GroupGrid.drawCard(data);
        ū.unbindBusy();
    },
    error: function() {
        // Shows Retry Thingy.
        $(ū.id(AddGroup.HOOKS.SuccessPanel)).slideUp();
        $(ū.id(AddGroup.HOOKS.ErrorPanel)).slideDown();
        $(ū.id(AddGroup.HOOKS.CreatePanel)).slideUp();
    },
    create: function() {
        if (AddGroup.ACTIVE) return;
        ū.bindBusy();
        AddGroup.createRequest(AddGroup.success, AddGroup.error);
    },
    retry: function() {
        AddGroup.create();
    },
    hide: function() {
        $(ū.id(AddGroup.HOOKS.SuccessPanel)).slideUp();
        $(ū.id(AddGroup.HOOKS.ErrorPanel)).slideUp();
        $(ū.id(AddGroup.HOOKS.CreatePanel)).slideDown();
    },
    init: function() {
        if (ū.IDExists(AddGroup.HOOKS.CreatePanel)) {
            $(ū.id(AddGroup.HOOKS.CreatePanelButton)).click(function() {AddGroup.create();});
            $(ū.cls(AddGroup.HOOKS.GlobalHideButton)).click(function() {AddGroup.hide();});
            $(ū.cls(AddGroup.HOOKS.GlobalRetryButton)).click(function() {AddGroup.create();});
        }
    }
};

var ū = {
    bindBusy: function() {
        $('*').css('cursor','wait');
    },
    unbindBusy: function() {
        $('*').css('cursor','');
    },
    isset: function(obj) {
        return !(typeof obj === "undefined" || obj === null);
    },

    IDExists: function(id) {
        if (document.getElementById(id)) return true;
        else return false;
    },

    id: function(id) {
        return "#"+id;
    },

    cls: function(cls) {
        return "."+cls;
    },

    /**
     * WCF: Whatever Comes First.
     * Argument lots of (fetched?) variables and whichever variable is found
     * defined first is returned.
     * Useful in cases when the data is fetched from outside source and might
     * not contain a particular field. This will provide a fallback to the next
     * variable/constant.
     */
    WCF: function() {
        for (var i = 0; i < arguments.length; i++) {
            if (ū.isset(arguments[i])) return arguments[i];
        }
        return null;
    }
}

GroupGrid.gridInit();
AddGroup.init();