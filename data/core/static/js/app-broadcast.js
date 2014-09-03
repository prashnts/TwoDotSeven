var Broadcast = {
	HOOKID : "broadcast-container",
	GETURI : "/dev/broadcast/feed",
	getHook : function() {
		return $("#"+this.HOOKID);
	},
	prependPost : function(feed) {
		//
	},
	fetchPosts : function() {
		$.getJSON(this.GETURI, function(data) {
			for (var i = data.length - 1; i >= 0; i--) {
				var feed = Broadcast.createPost(data[i]);
				$(feed).hide().prependTo("#broadcast-container").slideDown();
			};
		})
	},
	createPost : function(data) {
		var _Post = "";
		console.log(data);
		_Post +=	'<li class="broadcast-card broadcast-default" id="BROADCAST_'+data.ID+'">';
		_Post +=		'<a href="'+data.Meta.OP.URI+'" class="thumb pull-left m-r-sm">';
		_Post +=			'<img src="'+data.Meta.OP.IMG+'" class="img-circle b-a b-3x b-white">';
		_Post +=		'</a>';
		_Post +=		'<div class="clear">';
		_Post +=			'<a href="'+data.Meta.OP.URI+'">';
		_Post +=				'<span class="text-dark h4">'+data.Meta.OP.Name+' </span>';
		_Post +=				'<span class="h5">';
		_Post +=					'@'+data.Meta.OP.UserName+' ';
		_Post +=					'&bullet; ';
		_Post +=				'</span>';
		_Post +=				'<span class="h5">';
		_Post +=					data.TargetType+' ';
		for (var i = 0; i < data.Meta.TaggedUsers.length; i++) {
		_Post +=					'<a href="'+data.Meta.TaggedUsers[i].URI+'" class="label bg-primary">'+data.Meta.TaggedUsers[i].UserName+'</a> ';
		};
		_Post +=				'</span>';
		_Post +=				'<br>'
		_Post +=				'<span class="h6 text-muted">';
		_Post +=					'Posted '+data.TimeAgo;
		_Post +=					' &bullet; ';
		_Post +=					'<i class="fa '+data.VisibleClass+'"></i>';
		_Post +=				'</span>';
		_Post +=			'</a>';
		_Post +=			'<hr class="m-t-xs m-b-xs">';
		_Post +=			'<p>'+data.Data+'</p>';
		_Post +=		'</div>';
		_Post +=		'<div class="broadcast-card-actions">';
		_Post +=		'</div>';
		_Post +=	'</li>';

		return _Post;
	}
}

setTimeout(Broadcast.fetchPosts(), 1000);