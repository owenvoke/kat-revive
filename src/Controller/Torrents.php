<?php

namespace pxgamer\KatRevive\Controller;

class Torrents extends Controller
{
    public function index()
    {
        $total_torrents = $this->connection->query("SELECT COUNT(*) AS count FROM t_collection")->fetch();
        if ($total_torrents['count']) {
            $total_torrents = $total_torrents['count'];
        } else {
            $total_torrents = 0;
        }

        if (isset($this->query['s']) && $this->query['s'] < $total_torrents + 1) {
            $start = (int)$this->query['s'];
        } else {
            $start = 0;
        }

        $stmt = $this->connection->prepare("SELECT * FROM t_collection LIMIT :start, 20");
        $stmt->bindValue(':start', (int)$start, \PDO::PARAM_INT);
        $stmt->execute();

        $torrents = $stmt->fetchAll();

        $this->smarty->display(
            'index.tpl',
            [
                'total_torrents' => $total_torrents,
                'torrents' => $torrents,
                'start' => $start
            ]
        );
    }

    public function show()
    {
        $hash = isset($this->args['hash']) ? $this->args['hash'] : (isset($this->body['hash']) ? $this->body['hash'] : '');
        $stmt = $this->connection->prepare("SELECT * FROM t_collection WHERE torrent_info_hash = :hash");
        $stmt->bindValue(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();

        $torrent = $stmt->fetch();

        $error = false;

        if (strlen($hash) !== 40) {
            $error = 1;
        }
        $this->smarty->display(
            'torrents/show.tpl',
            [
                'torrent' => $torrent,
                'error' => $error
            ]
        );
    }
}