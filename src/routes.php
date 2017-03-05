<?php
// Routes

/*
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
*/

/*
 * * * * * * * * * * * * *
 * frontEndPages::start  *
 * * * * * * * * * * * * *
 */

$app->get('/', function ($request, $response, $args) {

    $books = new Models\Books();
    $books->find_all();

    $args['template_content'] = 'home_content.phtml';
    $args['template_menu'] = 'menu.phtml';
    $args['books'] = $books->params;
    $args['user_name'] = 'Guest';
    $args['title'] = 'homepage';
    $args['header'] = 'This is home page of my library';

    // Render index view
    return $this->renderer->render($response, 'my/layout.phtml', $args);
});

$app->get('/authors', function ($request, $response, $args) {

    $authors = new Models\Authors();
    $authors->find_all();

    $args['template_content'] = 'authors_content.phtml';
    $args['template_menu'] = 'menu.phtml';
    $args['authors'] = $authors->params;
    $args['user_name'] = 'Guest';
    $args['title'] = 'page of authors';
    $args['header'] = 'This is page of authors';

    return $this->renderer->render($response, 'my/layout.phtml', $args);

});

/*
 * * * * * * * * * * * *
 * frontEndPages::end  *
 * * * * * * * * * * * *
 */

/*
 * * * * * * * * * *
 * apiPages::start *
 * * * * * * * * * *
 */

// session status
$app->get( '/api/session/status', function ($request, $response) {
    $status = true;

    if ( $status ) {

        $response->write('page 200, Access Open ( Доступ Открыт )');
        return $response;

    } else {

    $newResponse = $response->withStatus(403);
    $newResponse->write('page 403, Access Denied ( Доступ Закрыт )');
    return $newResponse;

    }
});

// __my__ get all books as json
$app->get('/api/books', function () {

    $book = new Models\Books();
    $book->find_all();

    // header('Content-Type: application/json');
    if(isset($book->params)) {
        echo json_encode($book->params);
    }

});

// __my__ get one book as json
$app->get('/api/books/{id}', function ($request) {

    $id = $request->getAttribute('id');
    $book = new Models\Books();
    $book->find_one($id);

    // header('Content-Type: application/json');
    if(isset($book->params)) {
        echo json_encode($book->params);
    }

});

// __my__ post one book
$app->post('/api/books', function ($request) {

    $title = $request->getParsedBody()['book_title'];
    $author = $request->getParsedBody()['book_author_id'];

    $book = new Models\Books();
    $book->add($title, $author);

});

// __my__ update one book
$app->put('/api/books/{id}', function ($request) {

    $id = $request->getAttribute('id');
    $title = $request->getParsedBody()['book_title'];
    $author = $request->getParsedBody()['book_author_id'];

    $book = new Models\Books();
    $book->id = $id;
    $book->update($title, $author);

});

// __my__ delete one book
$app->delete('/api/books/{id}', function ($request) {

    $id = $request->getAttribute('id');

    $book = new Models\Books();
    $book->delete($id);

});

// __my__ get all authors as json
$app->get('/api/authors', function () {

    $authors = new Models\Authors();
    $authors->find_all();

    // header('Content-Type: application/json');
    if(isset($authors->params)) {
        echo json_encode($authors->params);
    }

});

/*
 * * * * * * * * * *
 * apiPages::end *
 * * * * * * * * * *
 */