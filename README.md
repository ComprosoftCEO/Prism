# Prism
Blog website for the Pike High School Sogeti Hackathon 2016

<br>

## Team Members
* Bryan McClain - PHP Programmer
* Melissa Ruiz - PHP Programmer
* Ethan Aguilar - HTML/CSS
* Tyler Ruth - HTML/CSS
* Arica Simon - Graphic Design

<br>

## Website Features
* Minimalistic design with easy-to-use interface
* Functional search engine for finding blog posts
* Multiple secure account system
    * Uses bcrypt hashing algorithm for storing passwords
    * Each account has a profile page
* Set the visibility for a blog post:
    * __Public__ - The post is searchable and can be visited with the link
    * __Link Only__ - The post is not listed in the search engine, but can still be viewed publically with the correct link
    * __Private__ - Only the owner of the blog post can view it
* Built-in protection against SQL injection and cross-site scripting

<br>

## Installing and Running
1. Install [Lamp](https://en.wikipedia.org/wiki/LAMP_(software_bundle)) on Linux Platforms or [WampServer](http://www.wampserver.com/en/) on Windows Platforms
2. Load the database structure from "prism.sql" using the PhpMyAdmin SQL database interface. The name of the loaded database should be "prism."
3. Create a database account using PhpMyAdmin that allows access to the prism database. The account should have permission to execute SELECT, INSERT, UPDATE, and DELETE on the database.
4. Copy the "htdocs" folder into the web server folder
  * __Linux:__ /var/www/
  * __Windows:__ \<wamp-folder\>\www\    _(default folder is C:\wamp\www\)_
5. Modify the file "config.php" to set the hostname, username, and password for database access
