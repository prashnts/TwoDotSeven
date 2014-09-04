var Broadcast = {
	HOOKID : "broadcast-container",
	PREURI : "/dev/broadcast/feed/pre/",
	POSTURI : "/dev/broadcast/feed/post/",
	POSTFIX : false,
	PREFIX : false,
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
		$.getJSON(Broadcast.PREURI+Broadcast.getPREFIX(), function(data) {
			Broadcast.prependIntoHook(data);
		});
	},
	postFetch : function() {
		$.getJSON(Broadcast.POSTURI+Broadcast.getPOSTFIX(), function(data) {
			Broadcast.appendIntoHook(data);
		});
	},
	prependIntoHook : function(data) {
		for (var i = data.length - 1; i >= 0; i--) {
			var feed = Broadcast.createPost(data[i]);
			$(feed).hide().prependTo("#"+Broadcast.HOOKID).delay(90*i).slideDown(100);
		};
	},
	appendIntoHook : function(data) {
		for (var i = 0; i < data.length; i++) {
			var feed = Broadcast.createPost(data[i]);
			$(feed).hide().appendTo("#"+Broadcast.HOOKID).delay(90*i).slideDown(100);
		};
	},
	createPost : function(data) {
		var _Post = "";
		//console.log(data);
		_Post +=	'<li class="broadcast-card broadcast-default" id="BROADCAST_'+data.ID+'" data-timestamp="'+data.Timestamp+'">';
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

Broadcast.postFetch();
console.log(Broadcast.getPOSTFIX());
console.log(Broadcast.getPREFIX());

setInterval(function() {
	Broadcast.preFetch();
}, 5000);

$('#broadcast').bind('scroll', function() {
	if($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
		Broadcast.postFetch();
	}
})