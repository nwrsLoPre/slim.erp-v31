<?php

// namespace Books;
namespace Models;
// use Models\Core;
// use Models\Core\model;

class Books extends Model
{
    public $title;
    public $author;

    public function add($title, $author) {

        $model = new Model;
        $mysqli = $model->connect();

        $query = "INSERT INTO books (`title`, `author_id`) VALUES (?, ?)";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("ss", $title, $author);

        $title = htmlspecialchars(stripslashes($title));
        $author = htmlspecialchars(stripslashes($author));

        if ( !empty($title) && !empty($author) )
        {

            try {
                $statement->execute();
            } catch (Exception $e) {
                return $response->withJson([
                    'status'    =>  false,
                    'message'   =>  $e->getMessage()
                ]);
            }

        }
    }

    public function update($title, $author = null) {

        $model = new Model;
        $mysqli = $model->connect();

        $query = "UPDATE `books` SET `title` = ?, `author_id` = ? WHERE id = '{$this->id}'";
        $statement = $mysqli->prepare($query);
        $statement->bind_param("ss", $title, $author);

        $title = htmlspecialchars(stripslashes($title));
        $author = htmlspecialchars(stripslashes($author));

        if ( !empty($title) && !empty($author) )
        {

            try {
                $statement->execute();
            } catch (Exception $e) {
                return $response->withJson([
                    'status'    =>  false,
                    'message'   =>  $e->getMessage()
                ]);
            }

        }
    }

}