var Broadcast = {
	HOOKID : "broadcast-container",
	getHook : function() {
		return $("#"+this.HOOKID);
	},
	createPost : function(data) {
		var _Post = "";
		_Post +=	'<li class="broadcast-card broadcast-default" id="POST_'+data.ID+'">';
		_Post +=		'<a href="'+data.Meta.OP.URI+'" class="thumb pull-left m-r-sm">';
		_Post +=			'<img src="'+data.Meta.OP.IMG+'" class="img-circle b-a b-3x b-white">';
		_Post +=		'</a>';
		_Post +=		'<div class="clear">';
		_Post +=			'<a href="'+data.URI+'">';
		_Post +=				'<span class="text-dark h4">'+data.Meta.OP.Name+' </span>';
		_Post +=				'<span class="h5">';
		_Post +=					'@'+data.Meta.OP.UserName+' ';
		for (var i = 0; i < data.Meta.OP.Tags.length; i++) {
		_Post +=					'<a href="'+data.Meta.OP.Tags[i].URI+'" class="label '+data.Meta.OP.Tags[i]._class+'">'+data.Meta.OP.Tags[i]._text+'</a> ';
		};
		_Post +=					'&bullet; ';
		_Post +=				'</span>';
		_Post +=				'<span class="h5">';
		_Post +=					'in ';
		for (var i = 0; i < data.Meta.OP.Tags.length; i++) {
		_Post +=					'<a href="'+data.Meta.OP.Tags[i].URI+'" class="label '+data.Meta.OP.Tags[i]._class+'">'+data.Meta.OP.Tags[i]._text+'</a> ';
		};
		_Post +=					'with ';
		for (var i = 0; i < data.Meta.OP.Tags.length; i++) {
		_Post +=					'<a href="'+data.Meta.TaggedUsers.Tags[i].URI+'" class="label '+data.Meta.TaggedUsers.Tags[i].._class+'">'+data.Meta.TaggedUsers.Tags[i].UserName+'</a> ';
		};

		_Post +=				'</span>';
		_Post +=				'<br>'
		_Post +=				'<span class="h6 text-muted">';
		_Post +=					'Posted 4 Minutes Ago';
		_Post +=					'&bullet;';
		_Post +=					'<i class="fa fa-globe"></i>';
		_Post +=				'</span>';
		_Post +=			'</a>';
		_Post +=			'<hr class="m-t-xs m-b-xs">';
		_Post +=			'<p><img src="http://www.thatsitcom.co.za/wp-content/uploads/2012/08/infographics.jpg" class="img-responsive"></p>';
		_Post +=		'</div>';
		_Post +=		'<div class="broadcast-card-actions">';
		_Post +=			'LOL?';
		_Post +=		'</div>';
		_Post +=	'</li>';

		return _Post;
	}
}