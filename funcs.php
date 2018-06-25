<?php
    namespace funcs;

    class Functions
    {

        public static function conn() {
            /* MySQL VARIABLES */
            $db_serv = "localhost";
            $db_user = "root";
            $db_pass = "";
            $db_name = "kat_db";

            return mysqli_connect($db_serv, $db_user, $db_pass, $db_name);
        }

        /**
         * @param boolean $db_conn
         * @param string $sql
         */
        public static function query($db_conn, $sql) {
            return mysqli_query($db_conn, $sql);
        }

        public static function changeDbDetails($mysql_host = "localhost", $mysql_username = "root", $mysql_password = "", $mysql_dbname = "kat_db") {

            // Open funcs.php file for editing
            $fname = "funcs.php";
            $content = file_get_contents($fname);

            // Replace with new details
            $content = preg_replace(
                [
                    '/\$db_serv = "(.*)"/',
                    '/\$db_user = "(.*)"/',
                    '/\$db_pass = "(.*)"/',
                    '/\$db_name = "(.*)"/'
                ],
                [
                    '$db_serv = "'.$mysql_host.'"',
                    '$db_user = "'.$mysql_username.'"',
                    '$db_pass = "'.$mysql_password.'"',
                    '$db_name = "'.$mysql_dbname.'"'
                ],
                $content,
                1
            );

            // Write to funcs.php
            if (file_put_contents($fname, $content)) {
                return true;
            }

            return false;
        }

    }
?>
