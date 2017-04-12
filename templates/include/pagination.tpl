<div class="text-center">
    <nav>
        <ul class="pagination">
            <li>
                <a href="?s={if ($start>20)}{$start-20}{else}0{/if}"
                   aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li><a href="#">Currently On Point: {$start} of {$total_torrents}</a></li>
            <li>
                <a href="?s={$start+20}"
                   aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>