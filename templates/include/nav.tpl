<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">KatRevive</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/torrent">
                        Hash Search
                    </a>
                </li>
                <li>
                    <form class="navbar-form navbar-left" role="search" action="/search" method="get">
                        <div class="form-group">
                            <input name="q" type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Search for Torrents</button>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><span class="glyphicon glyphicon-cog"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/torrent">
                                <span class="glyphicon glyphicon-flash"></span>
                                Hash Search
                            </a>
                        </li>
                        <li><a href="/upload"><span class="glyphicon glyphicon-open"></span> Upload
                                Torrent</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/api" target="_blank"><span class="glyphicon glyphicon-book"></span> API</a>
                        </li>
                        <li><a href="/exports"><span class="glyphicon glyphicon-cloud-download"></span>
                                Data Dumps</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#kat_theme">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                {if isset($_COOKIE['kat_theme'])}
                                    Enable
                                {else}
                                    Disable
                                {/if}
                                Kat Theme
                            </a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="https://github.com/PXgamer/KatRevive/issues/" target="_blank">
                                <span class="glyphicon glyphicon-alert"></span> Report Issue
                            </a>
                        </li>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
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
</div>
