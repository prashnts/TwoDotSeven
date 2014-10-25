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
            $(Container).append( string );
            $(Container).masonry( 'reloadItems' );
            $(Container).masonry( 'layout' );
        }
    },
    gridInit: function() {
        if (this.DONE) return;
        if (ū.IDExists(this.HOOKID)) {
            this.masonry.init();
            this.get(GroupGrid.drawRoutine);
        }
    }
};

var AddGroup = {
    CREATEHOOK: "Cluster-Add-Panel-Create",
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
    },
    createRequest: function(success, error) {
        this.ACTIVE = true;
        $.getJSON(this.ADDURI)
            .done(function(data) {
                if (success) {
                    success(data);
                }
                this.ACTIVE = false;
            })
            .fail(function(data) {
                if (error) {
                    error(data);
                }
                this.ACTIVE = false;
            });
    },
    success: function(data) {
        // 1. Redraw Success Panel.
        // 2. Show Success Panel.
        // 3. Add Card.
        // 4. Wait, and hide the Success Panel.
        $(ū.id(AddGroup.HOOKS.SuccessPanelGroupID)).html(ū.WCF(data.GroupID, "grpID"));
        $(ū.id(AddGroup.HOOKS.SuccessPanelURI)).html(ū.WCF(data.URI), "#");
        $(ū.id(AddGroup.HOOKS.SuccessPanelURI)).attr("href", ū.WCF(data.URI), "#");
        $(ū.id(AddGroup.HOOKS.SuccessPanelGoTo)).attr("href", ū.WCF(data.URI), "#");
        
        $(ū.id(AddGroup.HOOKS.SuccessPanel)).slideDown();
        $(ū.id(AddGroup.HOOKS.ErrorPanel)).slideUp();
        $(ū.id(AddGroup.HOOKS.CreatePanel)).slideUp();
        
        GroupGrid.drawCard(data);
    }
};

var ū = {
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