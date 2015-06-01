vf.registerModule('Notification', {

	send: function(title, icon, body, callback) {
		if (Notification.permission !== "granted")
			Notification.requestPermission();
		else {
			var notification = new Notification(title, {
				icon: icon,
				body: body
			});

			notification.onclick = callback;
		}
	}
});
