//permitir acceso solo al admin
(function(){
	function hasAdmin(){
		var stored = sessionStorage.getItem('roles') || localStorage.getItem('roles');
		if(!stored) return false;
		try{
			var roles = JSON.parse(stored);
			if(!Array.isArray(roles)) return false;
			for(var i=0;i<roles.length;i++){
				if(roles[i] && roles[i].nombre_rol === 'admin_k') return true;
			}
			return false;
		}catch(e){
			return false;
		}
	}

	function isAuthenticated(){
		var logged = sessionStorage.getItem('userLoggedIn') || localStorage.getItem('userLoggedIn');
		var token = sessionStorage.getItem('token') || localStorage.getItem('token');
		return !!(logged && token);
	}

	if(!isAuthenticated()){
		window.location.href = "login";
		return;
	}

	if(!hasAdmin()){
		window.location.href = "home";
	}
})();


