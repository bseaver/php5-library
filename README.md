# Library

#### Epicodus PHP Week 5 Team Project, 3/6-9/2017

#### By Maggie Harrington, Jayeson Kiyabu, Jake Campa, Benjamin T. Seaver

## Description
As a librarian, I want to create, read, update, delete, and list books in the catalog, so that we can keep track of our inventory.

As a librarian, I want to search for a book by author or title, so that I can find a book when there are a lot of books in the library.

As a librarian, I want to enter multiple authors for a book, so that I can include accurate information in my catalog. (Hint: make an authors table and a books table with a many-to-many relationship.)

As a patron, I want to check a book out, so that I can take it home with me.

As a patron, I want to know how many copies of a book are on the shelf, so that I can see if any are available. (Hint: make a copies table; a book should have many copies.)

As a patron, I want to see a history of all the books I checked out, so that I can look up the name of that awesome sci-fi novel I read three years ago. (Hint: make a checkouts table that is a join table between patrons and copies.)

As a patron, I want to know when a book I checked out is due, so that I know when to return it.

As a librarian, I want to see a list of overdue books, so that I can call up the patron who checked them out and tell them to bring them back - OR ELSE!

## Project Requirements:

## Setup Requirements
* See https://secure.php.net/ for details on installing _PHP_.  Note: PHP is typically already installed on Mac.
* See https://getcomposer.org/ for details on installing _composer_.
* See https://mamp.info/ for details on installing _MAMP_.

## Installation Instructions
* Clone project.
* From project root, run $ `composer install --prefer-source --no-interaction`
* Start MAMP servers.
* Use MAMP website `http://localhost:8888/phpmyadmin/` to import database with sample data from the `shoes.sql.zip` file.
* To enable the PHPUnit Tests, use MAMP website to import the `shoes_test.sql.zip` database.
* To run PHPUnit tests from project root, run $ `vendor/bin/phpunit tests`
* To run website using installed _PHP_ (better error messages):
    * From web folder in project, run $ `php -S localhost:8000`.
    * In web browser open `localhost:8000`.
* To run website using _MAMP_:
    * Change the document root to the project web folder.
    * In web browser open `localhost:8888`.
* To start interactive SQL at command prompt run $ `/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot`

## Known Bugs
* No known bugs

## Support and contact details
* No support

## Technologies Used
* PHP
* MAMP
* mySQL
* Composer
* PHPUnit
* Silex
* Twig
* Bootstrap
* HTML
* CSS
* Git

## Copyright (c)
* 2017 Maggie Harrington, Jayeson Kiyabu, Jake Campa, Benjamin T. Seaver

## License
* MIT

## Implementation Plan

* In interactive SQL, create database and tables (you can paste all lines below at once at the `mysql>` prompt):

CREATE DATABASE IF NOT EXISTS `library`;

USE `library`;

DROP TABLE IF EXISTS `genre`;

CREATE TABLE `genre` (`id` SERIAL PRIMARY KEY, `genre_name` varchar(255));

DROP TABLE IF EXISTS `book_copies`;

CREATE TABLE `book_copies` (`id` SERIAL PRIMARY KEY, `book_condition` TINYINT, `comment` VARCHAR (255), `book_id` BIGINT);

DROP TABLE IF EXISTS `checkouts`;

CREATE TABLE `checkouts` (`id` SERIAL PRIMARY KEY, `book_copy_id` BIGINT, `patron_id` BIGINT, `checkout_date` DATE, `due_date` DATE, `returned_date` DATE, `comment` VARCHAR (255), `still_out` TINYINT);

DROP TABLE IF EXISTS `authors`;

CREATE TABLE `authors` (`id` SERIAL PRIMARY KEY, `author_name` varchar(255));

DROP TABLE IF EXISTS `authors_books`;

CREATE TABLE `authors_books` (`id` SERIAL PRIMARY KEY, `author_id` bigint(20), `book_id` bigint(20));

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (`id` SERIAL PRIMARY KEY, `title` varchar(255), `publish_date` date, `synopsis` VARCHAR(255), `genre_id` bigint(20));

DROP TABLE IF EXISTS `patrons`;

CREATE TABLE `patrons` (`id` SERIAL PRIMARY KEY, `patron_name` varchar(255), `contact_info` varchar(255));

* Install dependencies (composer.json, composer.lock, .gitignore)
* Build and test objects for tables
* Create Silex framework (web/index.php, app/app.php)
* Create empty routes
* Design pages
* Implement routes with object operations and views

* End specifications
