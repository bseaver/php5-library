<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../app/AppHelperFunctions.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/AuthorBook.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/BookCopy.php";
    require_once __DIR__."/../src/Checkout.php";
    require_once __DIR__."/../src/Genre.php";
    require_once __DIR__."/../src/GenreBook.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();
    $app['debug'] = true;
    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render("index.html.twig");
    });

    $app->get("/librarian_view", function() use ($app) {
        return $app['twig']->render("librarian.html.twig", array('books' => Book::getSome('all')));
    });

    $app->post("/book_add", function() use ($app) {
        $book_title = $_POST['book_title'];
        $publish_date = $_POST['publish_date'];
        $synopsis = $_POST['synopsis'];
        $author_name = $_POST['author_name'];
        $book_copies = (int)$_POST['copies'];
        $author = AppHelperFunctions::getOrCreateAuthor($author_name);
        $author_id = $author->getId();
        $new_book = new Book($book_title, $publish_date, $synopsis);
        $new_book->save();
        $new_book_id = $new_book->getId();
        $new_author_book = new AuthorBook($author_id, $new_book_id);
        $new_author_book->save();

        for ($i = 0; $i < $book_copies; $i ++) {
            $new_book_copy = new BookCopy($new_book_id, 5, 'new');
            $new_book_copy->save();
        }
        return $app->redirect("/librarian_view");
    });

    $app->get("/book/{id}", function($id) use ($app){
        $copies = BookCopy::getSome('book_id', $id);
        $book = Book::getSome('id', $id);
        $book_id = $book[0]->getId();
        $author_books = AuthorBook::getSome('book_id', $book_id);
        $authors = array();
        foreach ($author_books as $author_book){
            $author_id = $author_book->getAuthorId();
            $author = Author::getSome('id', $author_id);
            array_push($authors, $author[0]);
        }
        return $app['twig']->render('edit_book.html.twig', array('book' => $book[0], 'copies' => $copies, 'authors' => $authors));
    });

    $app->post("/add_author", function() use ($app) {
        $new_author = $_POST['add_author'];
        $id = (int) $_POST['book_id'];
        $author = AppHelperFunctions::getOrCreateAuthor($new_author);
        $author_id = $author->getId();
        $new_author_book = new AuthorBook($author_id, $id);
        $new_author_book->save();

        return $app->redirect('/book/'.$id);
    });

    $app->patch("/update_book", function() use ($app) {
        $new_title = $_POST['update_title'];
        $new_synopsis = $_POST['update_synopsis'];
        $book_id = $_POST['book_id'];
        $new_book = Book::getSome('id', $book_id);
        $new_book[0]->updateTitle($new_title);
        $new_book[0]->updateSynopsis($new_synopsis);

        return $app->redirect('/librarian_view');
    });

    $app->delete("/delete_book/{id}", function($id) use ($app) {
        Book::deleteSome('id', $id);
        AuthorBook::deleteSome('book_id', $id);
        BookCopy::deleteSome('book_id', $id);
        //Delete from checkout when implemented
        return $app->redirect('/librarian_view');
    });

    $app->get("/edit_book_copy/{id}", function($id) use ($app) {
        $copy = BookCopy::getSome('id', $id);
        return $app['twig']->render('edit_book_copy.html.twig', array('copy' => $copy[0]));
    });

    $app->patch("/update_book_copy/{id}", function($id) use ($app) {
        $book = Book::getSome('id', $id);
        $new_condition = $_POST['update_condition'];
        $new_comments = $_POST['update_comments'];
        $new_book_copy = BookCopy::getSome('id', $id);
        $book_id = $new_book_copy[0]->getBookId();
        $new_book_copy[0]->update($book_id, $new_condition, $new_comments);
        return $app->redirect('/book/'.$book_id);
    });

    $app->get("/patron_view", function() use ($app) {
        return $app['twig']->render("patron.html.twig");
    });

    $app->post("/patron_login", function() use ($app) {
        $username = $_POST['username'];
        $patron = Patron::getSome('patron_name', $username);
        if (empty($patron)) {
            return $app->redirect("/patron_view");
        } else {
            return $app['twig']->render("patron_login.html.twig", array('patron' => $patron[0]));
        }
    });

    $app->post("/title_search", function() use ($app) {
        $title = $_POST['title'];
        $books = Book::getSome('title_search', $title);
        $books_data = [];
        foreach ($books as $book) {
            $author_books = AuthorBook::getSome('book_id', $book->getId());
            $author_list = '';
            foreach ($author_books as  $author_book) {
                $authors = Author::getSome('id',$author_book->getAuthorId());
                $author_list .= ($author_list?' / ':'') . $authors[0]->getAuthorName();
            }
            $item = array(
                'getTitle' => $book->getTitle(),
                'getSynopsis' => $book->getSynopsis(),
                'getId' => $book->getId(),
                'getPublishDate' => $book->getPublishDate(),
                'author_list' => $author_list
            );
            array_push($books_data, $item);
        }
        return $app['twig']->render("title_search.html.twig", array('books' => $books_data));
    });

    $app->post("/librarian_title_search", function() use ($app) {
        $title = $_POST['title'];
        $books = Book::getSome('title_search', $title);
        $books_data = [];
        foreach ($books as $book) {
            $author_books = AuthorBook::getSome('book_id', $book->getId());
            $author_list = '';
            foreach ($author_books as  $author_book) {
                $authors = Author::getSome('id',$author_book->getAuthorId());
                $author_list .= ($author_list?' / ':'') . $authors[0]->getAuthorName();
            }
            $item = array(
                'getTitle' => $book->getTitle(),
                'getSynopsis' => $book->getSynopsis(),
                'getId' => $book->getId(),
                'getPublishDate' => $book->getPublishDate(),
                'author_list' => $author_list
            );
            array_push($books_data, $item);
        }
        return $app['twig']->render("librarian_title_search.html.twig", array('books' => $books_data));
    });

    $app->post("/author_search", function() use ($app) {
        $author_name = $_POST['author_name'];
        $authors = Author::getSome('author_search', $author_name);
        $authors_data = [];
        foreach ($authors as $author) {
            $author_books = AuthorBook::getSome('author_id', $author->getId());
            $book_list = '';
            foreach ($author_books as  $author_book) {
                $books = Book::getSome('id',$author_book->getBookId());
                $book_list .= ($book_list?' / ':'') . $books[0]->getTitle();
            }
            $item = array(
                'getAuthorName' => $author->getAuthorName(),
                'book_list' => $book_list
            );
            array_push($authors_data, $item);
        }
        return $app['twig']->render("author_search.html.twig", array('authors' => $authors_data));
    });

    $app->post("/librarian_author_search", function() use ($app) {
        $author_name = $_POST['author_name'];
        $authors = Author::getSome('author_search', $author_name);
        $authors_data = [];
        foreach ($authors as $author) {
            $author_books = AuthorBook::getSome('author_id', $author->getId());
            $book_list = '';
            foreach ($author_books as  $author_book) {
                $books = Book::getSome('id',$author_book->getBookId());
                $book_list .= ($book_list?' / ':'') . $books[0]->getTitle();
            }
            $item = array(
                'getAuthorName' => $author->getAuthorName(),
                'book_list' => $book_list
            );
            array_push($authors_data, $item);
        }
        return $app['twig']->render("librarian_author_search.html.twig", array('authors' => $authors_data));
    });

    $app->delete("/delete_book_copy/{id}", function($id) use ($app) {
        $new_book_copy = BookCopy::getSome('id', $id);
        $book_id = $new_book_copy[0]->getBookId();
        BookCopy::deleteSome('id', $id);
        return $app->redirect('/book/'.$book_id);
    });

    $app->post("/patron_checkout", function() use ($app) {
        $patron_id = $_POST['patron_id'];
        $book_copy_id = $_POST['book_copy_id'];
        $checkout_date = '2017-03-09';
        $due_date = '2017-03-23';
        $still_out = 1;
        $returned_date = '';
        $comment = '';
        $new_checkout = new Checkout($book_copy_id, $patron_id, $checkout_date, $due_date, $returned_date, $comment, $still_out);
        return $app->redirect('/patron_login');
    });

    $app->get("/librarian_checkout", function() use ($app) {
        $checkouts = Checkout::getSome('all');
        $patrons = array();
        foreach ($checkouts as $checkout) {
            $patron = Patron::getSome('id', $checkout->getPatronId());
            array_push($patrons, $patron);
        }
        return $app['twig']->render('librarian_checkout.html.twig', array('patrons' => $patrons));
    });

    return $app;
 ?>
