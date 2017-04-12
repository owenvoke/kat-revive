<?php

namespace pxgamer\KatRevive\Meta;

class Torrents
{
    public static $trackers = [
        'udp://tracker.coppersurfer.tk:6969/announce',
        'udp://glotorrents.pw:6969/announce',
        'udp://tracker.openbittorrent.com:80/announce',
        'udp://tracker.opentrackr.org:1337/announce'
    ];

    public static function magnet($info_hash = null, $title = null)
    {
        $magnet = '';
        if ($info_hash && $title) {
            $magnet .= 'magnet:?xt=urn:btih:';
            $magnet .= $info_hash;
            $magnet .= '&dn=' . urlencode($title);

            foreach (self::$trackers as $tracker) {
                $magnet .= '&tr=' . urlencode($tracker);
            }
        }

        return $magnet;
    }
}