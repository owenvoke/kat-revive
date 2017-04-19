<?php

namespace pxgamer\KatRevive\Meta;

class Torrents
{
    const ERROR_INCORRECT_BSON = 'Incorrect BSON format.';

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

    /**
     * @param string $s
     * @return array|bool|string
     */
    public static function parse($s)
    {
        static $str;
        $str = $s;
        if ($str{0} == 'd') {
            $str = substr($str, 1);
            $ret = array();
            while (strlen($str) && $str{0} != 'e') {
                $key = self::parse($str);
                if (strlen($str) == strlen($s)) {
                    break;
                }
                // prevent endless cycle if no changes made
                if (!strcmp($key, "info")) {
                    $save = $str;
                }
                $value = self::parse($str);
                if (!strcmp($key, "info")) {
                    $tosha = substr($save, 0, strlen($save) - strlen($str));
                    $ret['info_hash'] = sha1($tosha);
                }
                // process hashes - make this stuff an array by piece
                if (!strcmp($key, "pieces")) {
                    $value = explode("====",
                        substr(
                            chunk_split($value, 20, "===="),
                            0, -4
                        )
                    );
                };
                $ret[$key] = $value;
            }
            $str = substr($str, 1);
            return $ret;
        } else {
            if ($str{0} == 'i') {
                $ret = substr($str, 1, strpos($str, "e") - 1);
                $str = substr($str, strpos($str, "e") + 1);
                return $ret;
            } else {
                if ($str{0} == 'l') {
                    $ret = array();
                    $str = substr($str, 1);
                    while (strlen($str) && $str{0} != 'e') {
                        $value = self::parse($str);
                        if (strlen($str) == strlen($s)) {
                            break;
                        }
                        // prevent endless cycle if no changes made
                        $ret[] = $value;
                    }
                    $str = substr($str, 1);
                    return $ret;
                } else {
                    if (is_numeric($str{0})) {
                        $namelen = substr($str, 0, strpos($str, ":"));
                        $name = substr($str, strpos($str, ":") + 1, $namelen);
                        $str = substr($str, strpos($str, ":") + 1 + $namelen);
                        return $name;
                    }
                }
            }
        }

        return '';
    }

    /**
     * @param int $int
     * @param int $length
     *
     * @return string
     */
    public static function file_size($int, $length = 4)
    {
        $int = (int)$int;
        switch (true) {
            case $int < 1024:
                return $int . 'B';
            case $int < 1048576:
                return self::trim_num($int / 1024, $length) . ' <span>KB</span>';
            case $int < 1073741824:
                return self::trim_num($int / 1048576, $length) . ' <span>MB</span>';
            default:
                return self::trim_num($int / 1073741824, $length) . ' <span>GB</span>';
        }
    }

    /**
     * @param int $num
     * @param int $len
     *
     * @return string
     */
    public static function trim_num($num, $len)
    {
        if (strlen($num) <= $len) {
            return $num;
        }
        while (strlen($num) > $len) {
            $num = substr($num, 0, -1);
        }
        $num = trim($num, '.');

        return $num;
    }

}