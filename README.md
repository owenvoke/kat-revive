# kat-revive

[![Software License][ico-license]](LICENSE.md)
[![Open Issues][ico-issues-open]][link-issues-open]
[![Closed Issues][ico-issues-closed]][link-issues-closed]

KatRevive is a project to allow revival of the Kickass Torrents API dumps.

## Install

Via Git

```bash
git clone https://github.com/pxgamer/kat-revive.git
```  

1. Set your details in the `funcs.php` file (it will also ask during the install if it's unable to connect).
2. Copy the SQL out of the `create_db.sql` file and run this in your MySQL administration tool.
3. Copy your `hourlydump.txt` and/or `dailydump.txt` file(s) to the `import_lists` folder.  
4. Open the `install.php` file in a browser, and check that no errors appear, if not, select the file you'd like to install. Then click `import`.  

This can take a while depending on the number of torrents your file contains, I tested with 3 Million+ torrents in the data dump I had, which took roughly 5 minutes, alternatively you can generate a MySQL import file using the `gen_sql_import.php` file.  

## Usage

**Hourly Dump Format**

Column | Type            | Format
------ | --------------- | ---------
0      | Torrent hash    | VARCHAR
1      | Title           | VARCHAR
2      | Category        | VARCHAR
3      | KAT URL         | VARCHAR
4      | Torcache URL    | VARCHAR
5      | Size (Bytes)    | BIGINT
6      | Category ID     | INT
7      | Number of files | INT
8      | UNKNOWN         | INT
9      | UNKNOWN         | INT
10     | Unix timestamp  | BIGINT
11     | Verified        | INT

**Other Features**

- [The API](api)
- [Main Search](search)
- [Hash Searching](hash)
- [MySQL Import Generation](sql_imports)

## Security

If you discover any security related issues, please email owzie123@gmail.com instead of using the issue tracker.

## Credits

- [pxgamer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-issues-open]: https://img.shields.io/github/issues/pxgamer/kat-revive.svg?style=flat-square
[ico-issues-closed]: https://img.shields.io/github/issues-closed/pxgamer/kat-revive.svg?style=flat-square

[link-issues-open]: https://github.com/pxgamer/kat-revive/issues
[link-issues-closed]: https://github.com/pxgamer/kat-revive/issues?q=is%3Aissue+is%3Aclosed
[link-author]: https://github.com/pxgamer
[link-contributors]: ../../contributors
