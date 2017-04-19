<?php

namespace pxgamer\KatRevive\Controller;

use pxgamer\KatRevive\Meta;

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

        $data = new \stdClass();

        $data->torrent = $stmt->fetch();

        $data->error = false;

        if (strlen($hash) !== 40) {
            $data->error = 1;
        }

        if (isset($data->torrent['size'])) {
            $data->torrent['size'] = Meta\Torrents::file_size($data->torrent['size']);
        }

        $this->smarty->display(
            'torrents/show.tpl',
            [
                'data' => $data
            ]
        );
    }

    public function upload()
    {
        $uploaded = [];

        if (isset($_FILES['torrent']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['torrent']['name']) && $_FILES['torrent']['size'] > 0) {
                $len = count($_FILES['torrent']['name']);

                for ($i = 0; $i < $len; ++$i) {
                    if (!file_exists($_FILES['torrent']['tmp_name'][$i])) {
                        continue;
                    }

                    $torrent_content = file_get_contents($_FILES['torrent']['tmp_name'][$i]);

                    if ($torrent_content !== null) {
                        $status = new \stdClass();
                        $status->success = false;
                        $torrent_data = Meta\Torrents::parse($torrent_content);

                        $file_count = 1;
                        $total_size = 1;
                        if (isset($torrent_data['info']['files']) && $torrent_data['info']['files'] !== null) { // Check if files param exists
                            for ($j = 0; $j < count($torrent_data['info']['files']) - 1; ++$j) {
                                $total_size = $total_size + (int)$torrent_data['info']['files'][$j]['length'];
                            }
                            $file_count = count($torrent_data['info']['files']);
                        }

                        if (isset($total_size) && isset($torrent_data['info_hash']) && isset($torrent_data['info']['name'])) {
                            if (!isset($torrent_data['creation date'])) {
                                $torrent_data['creation date'] = date('now');
                            }

                            $torrent = array(
                                'torrent_name' => $torrent_data['info']['name'],
                                'torrent_info_hash' => strtoupper($torrent_data['info_hash']),
                                'size' => $total_size,
                                'upload_date' => $torrent_data['creation date'],
                                'files_count' => $file_count,
                            );
                            $stmt = $this->connection->prepare("INSERT INTO t_collection (
                                                    torrent_info_hash, torrent_name, size, files_count, upload_date, category_id) VALUES
                                                    (:info_hash, :torrent_name, :size, :files, :date, :category_id)");

                            $stmt->bindParam(':info_hash', $torrent['torrent_info_hash'], \PDO::PARAM_STR);
                            $stmt->bindParam(':torrent_name', $torrent['torrent_name'], \PDO::PARAM_STR);
                            $stmt->bindParam(':size', $torrent['size'], \PDO::PARAM_INT);
                            $stmt->bindParam(':files', $torrent['files_count'], \PDO::PARAM_INT);
                            $stmt->bindParam(':date', $torrent['upload_date'], \PDO::PARAM_STR);

                            $category = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 55;
                            $stmt->bindParam(':category_id', $category, \PDO::PARAM_INT);

                            $status->success = $stmt->execute();
                            $status->torrent = $torrent;

                            if (!$status->success) {
                                $status->error = $stmt->errorInfo();
                            }
                        } else {
                            $status->error = Meta\Torrents::ERROR_INCORRECT_BSON;
                        }

                        if (!isset($status->torrent['torrent_name'])) {
                            $status->torrent['torrent_name'] = $_FILES['torrent']['name'];
                        }
                        $uploaded[] = $status;
                    }
                }
        }
    }

$this->smarty->display(
'torrents/upload.tpl',
['uploaded' => $uploaded,
'categories' => Meta\Categories::$List]
);
}
}