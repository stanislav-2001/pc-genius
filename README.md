# PCgenius

This is my hobby project that should represent a blog website for tech-related news and commentaries. 

## Features

- categories, related articles
- responsive
- small administration - GUI for markdown editing articles
- support for images
- support for newsletter, auto sending emails to the subscribers on publishing an article
- Disqus integration for comments
- cookie notice

## Set up

In order to run the website you need to run it on a working PHP server (for version, it should run even on older ones), that has GD and mysqli extensions activated in the `php.ini` config file.
In `config.php` then set default url. It is set to port 8080 on default.

Next, you should have MySQL server installed with an user and a database. You can set the credentials in `\db.php` AND \sql\db.php` (file unification is TODO atm). The database should be manually created at first.

Once you have this set up, you need to navigate to `/install.php` in browser to create all the necessary MySQL tables for you. In production, this file should be deleted afterwards.

The repo also contains .htaccess file that must be enabled on the server in order to make links work (it prettifies article urls and sets 404 page).

## Administration

The app contains a hidden administration accessible at the link `/adminka/adminka.php?pass=<PASS>` where PASS is, for now, a SHA1 hash of the admin password. Currently, the password is hard-coded and you can get the hash at `\pas.php`. This is a temporary solution,
header authentication is a TODO. If the argument with correct PASS is not provided, the web will show a 404.

The administration is a simple GUI that for now allows only to create a new article.

## Live demo

Uploading to a public hosting for a preview is planned.
