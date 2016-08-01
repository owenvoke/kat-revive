<?php if (isset($_COOKIE['kat_theme']) && $_COOKIE['kat_theme'] != '') {
    ?>
    <style>
    .nav.navbar-nav li a, .navbar-header .navbar-brand, .dropdown-menu>li>a {
    	color: #ffeeb4 !important;
    }
    .nav.navbar-nav li a:hover, .navbar-header .navbar-brand:hover, .dropdown-menu>li>a:hover {
        background: #2c240f !important;
    	color: #ffeeb4 !important;
    }
    .navbar.navbar-default, .dropdown-menu {
    	background: #594c2d !important;
    	border:none;
    	border-radius:0;
    }
    </style>
<?php

} ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">KatRevive</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    <ul class="nav navbar-nav">
        <li><a href="/hash/">Hash Search</a></li>
        <form class="navbar-form navbar-left" role="search" action="/search" method="get">
          <div class="form-group">
            <input name="q" type="text" class="form-control" placeholder="Search">
          </div>
          <button type="submit" class="btn btn-default">Search for Torrents</button>
        </form>
      </ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span></a>
          	<ul class="dropdown-menu">
							<li><a href="/hash/"><span class="glyphicon glyphicon-flash"></span> Hash Search</a></li>
							<li><a href="/upload/"><span class="glyphicon glyphicon-open"></span> Upload Torrent</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="/api/" target="_blank"><span class="glyphicon glyphicon-book"></span> API</a></li>
	            <li><a href="/cron/exports/"><span class="glyphicon glyphicon-cloud-download"></span> Data Dumps</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#" data-toggle="modal" data-target="#kat_theme"><span class="glyphicon glyphicon-eye-open"></span> <?php if (isset($_COOKIE['kat_theme']) && $_COOKIE['kat_theme'] != '') {
    ?>Disable KAT Theme<?php

} else {
    ?>Enable KAT Theme<?php

} ?></a></li>
							<li role="separator" class="divider"></li>
	            <li><a href="https://github.com/PXgamer/KatRevive/issues/" target="_blank"><span class="glyphicon glyphicon-alert"></span> Report Issue</a></li>
          	</ul>
        	</li>
      	</ul>
    	</div>
  	</div>
</nav>
<div class="modal fade" id="kat_theme" tabindex="-1" role="dialog" aria-labelledby="kat_theme">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">KAT Theme</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to turn the KAT theme on/off?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" onclick="enableKatTheme()">Yes</button>
      </div>
    </div>
  </div>
  <script>
	function enableKatTheme(mode) {
		var name = 'kat_theme=';
	    var ca = document.cookie.split(';');
		var cookie_val = '';
		var today = new Date();
		today.setDate(today.getDate() + 100);
	    for(var i = 0; i <ca.length; i++) {
	    	var c = ca[i];
	    	while (c.charAt(0)==' ') {
	    		c = c.substring(1);
	    	}
	    	if (c.indexOf(name) == 0) {
	    		cookie_val = c.substring(name.length,c.length);
	    	}
	    }
		if (cookie_val) {
			document.cookie = "kat_theme=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
		}
		else {
			document.cookie = "kat_theme=true; expires="+today+"; path=/";
		}
		location.reload();
	}
  </script>
</div>
