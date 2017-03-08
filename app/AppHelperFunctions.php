<?php
require_once __DIR__."/../src/Author.php";
require_once __DIR__."/../src/AuthorBook.php";
require_once __DIR__."/../src/Book.php";
require_once __DIR__."/../src/BookCopy.php";
require_once __DIR__."/../src/Checkout.php";
require_once __DIR__."/../src/Genre.php";
require_once __DIR__."/../src/GenreBook.php";
require_once __DIR__."/../src/Patron.php";

class AppHelperFunctions
{

    static function getOrCreateAuthor($author_name)
    {
        $author = Author::getSome('author_name', $author_name);
        var_dump($author);
        if (empty($author)) {
            $author = new Author($author_name);
            $author->save();
            $author = array($author);
        }
        $author = $author[0];
        return $author;
    }
}



 ?>
