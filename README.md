# KatRevive

[![Software License][ico-license]](LICENSE.md)
[![Open Issues][ico-issues-open]][link-issues-open]
[![Closed Issues][ico-issues-closed]][link-issues-closed]

KatRevive is a project to allow revival of the Kickass Torrents API dumps.

## Install

Clone to your local or remote server using `git clone https://github.com/pxgamer/KatRevive.git`.  

I have set this up to use MySQL with a username of `root` and no password. This can be changed in the `funcs.php` file, or during the install process.   

Next, copy the code out of the `create_db.sql` file and run this in your MySQL administration tool. For example, in PHPMyAdmin, navigate to the SQL tab for the database, and paste it there. Then run this. 

Copy your `hourlydump.txt` and/or `dailydump.txt` file(s) to the `import_lists` folder.  

Open the `install.php` file in a browser, and check that no errors appear, if not, select the file you'd like to install. Then click `import`.  

This can take a while depending on the number of torrents your file contains, I tested with 3 Million+ torrents in the data dump I had, which took roughly 5 minutes, alternatively you can generate a MySQL import file using the `gen_sql_import.php` file.  

## Hourly Dump Format
   | TYPE			| FORMATE
---|----------|--------------
0  | HASH			| [VARCHAR]
1  | TITLE			| [VARCHAR]
2  | CATEGORY 		| [VARCHAR]
3  | KAT URL		| [VARCHAR]
4  | TORCACHE URL	| [VARCHAR]
5  | SIZE (Bytes)	| [BIGINT]
6  | Category ID	| [INT]
7  | Num of Files	| [INT]
8  | UNKNOWN		| [INT]
9  | UNKNOWN		| [INT]
10 | DATE IN SECS	| [BIGINT]
11 | VERIFIED		| [INT]

## Other Features
The API: https://github.com/PXgamer/KatRevive/tree/master/api  
Main Search: https://github.com/PXgamer/KatRevive/tree/master/search  
Hash Searching: https://github.com/PXgamer/KatRevive/tree/master/hash  
MySQL Import Generation: https://github.com/PXgamer/KatRevive/tree/master/sql_imports  

## Gallery
#### Main Page
![Index Image](https://pximg.xyz/images/ee2b0357f515d530c7c46acc71d6d287.png)  
#### Individual Torrent Pages
![Individual Torrent Pages](https://pximg.xyz/images/fd181e06a5f5d4de7f0d6199e1a22c35.png)  
#### Main Search System
![Main Search](https://pximg.xyz/images/172911e84f10ddd93d3e41c02373bff6.png)  
#### API Results
![API Results](https://pximg.xyz/images/4dd5c7daf945c110945dcda6fad03dd9.png)  
#### KAT Header Theme
![KAT Header Theme](https://pximg.xyz/images/5bc7939c5fd0e74703b7b7e289dcab2e.png)

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-issues-open]: https://img.shields.io/github/issues/pxgamer/KatRevive.svg?style=flat-square
[ico-issues-closed]: https://img.shields.io/github/issues-closed/pxgamer/KatRevive.svg?style=flat-square

[link-issues-open]: https://github.com/PXgamer/KatRevive/issues
[link-issues-closed]: https://github.com/PXgamer/KatRevive/issues?q=is%3Aissue+is%3Aclosed
