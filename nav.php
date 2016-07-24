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
      <a class="navbar-brand" href="/">KAT Revive</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/hash/">Hash Search</a></li>
        <li><a href="/api/">API Search</a></li>
		<form class="navbar-form navbar-left" role="search" action="/hash" method="get">
			<div class="form-group">
				<input name="h" type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-default">Search Hash</button>
		</form>
      </ul>
    </div>
  </div>
</nav>
