# KatRevive

## About
KatRevive is a project to allow revival of the Kickass Torrents API dumps.

## Files
#### create_db.sql
This is the MySQL code needed to generate the database. By default, the username is *root* and the password is blank.  
To use this, copy it into a MySQL terminal instance, or copy it into PHPMyAdmin or your respective MySQL manager.  

#### index.php
This is the root file, and the file that you will use to view torrents. You can access other torrents by using the `GET` parameter of `s`.  
This layout shows 5 columns.
- Verified: Displayed as a star
- Hash: The info hash for that specific torrent, this is unique in the db
- Name: The name of the torrent
- Category: What main category it was in on KAT, the DB also contains the `category_id` which allows for subcategories as well
- URLs: The torrent file link, and the magnet link

#### install.php
The installer file. Just run this, and select an import type.  
*Please note, these will need to be downloaded beforehand and added to the `import_lists` folder.*  

There are 2 example [import files](https://github.com/PXgamer/KatRevive/tree/master/import_lists) with the same torrent, to demonstrate. The actual imports can be downloaded elsewhere.

Just select the type you want to import, and hit the import button.

#### import_db_list.php
This shouldn't be accessed from anywhere, it will automatically be called by using the `install.php` file.  
Please don't run this more than once, and please note that it **will** be slow when installing.

#### api/index.php
The API, will create a JSON formatted array of torrents. Is limited to 20 at a time, and can be browsed using the `GET` parameter `s`.

#### favicon.png
Just ignore this, it's the favicon to load when using the site in a browser.

#### funcs.php
No need to touch this file, unless changing the db details. It's self contained and used in the other files.

## Instructions
Clone to your local or remote server using `git clone https://github.com/PXgamer/KatRevive.git`.  

I have set this up to use MySQL with a username of `root` and no password. This can be changed in the `funcs.php` file.   

Next, copy the code out of the `create_db.sql` file and run this in your MySQL administration tool. For example, in PHPMyAdmin, navigate to the SQL tab, and paste it there. Then run this. 

Copy your `hourlydump.txt` and/or `dailydump.txt` file(s) to the `import_lists` folder.  

Open the `install.php` file in a browser, and select the file you'd like to install. Then click `import`.  

This can take a while depending on the number of torrents your file contains, I tested with 3 Million+ torrents in the data dump I had, which took roughly 10 minutes.  

## The Database/Table
The database is called `kat_db` by default and contains a single table `t_collection`. This table contains 10 columns, as follows:  
- torrent_info_hash
- torrent_name
- torrent_category
- torrent_info_url
- torrent_download_url
- size
- category_id
- files_count
- upload_date
- verified
