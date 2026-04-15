<?php
function query($pdo, $sql, $parameters = [])
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parameters);
    return $stmt;
}


// -- AUTHORS CRUD --


function getAuthorByEmail($pdo, $email)
{
    return query($pdo, 'SELECT * FROM `author` WHERE `email` = :email', [':email' => $email])->fetch();
}

function getAuthorById($pdo, $id)
{
    return query($pdo, 'SELECT * FROM `author` WHERE `id` = :id', [':id' => $id])->fetch();
}

// Add guest author (when user writes a review)
function insertAuthor($pdo, $name, $email)
{
    query($pdo, 'INSERT INTO `author` (`name`, `email`) VALUES (:name, :email)', [':name' => $name, ':email' => $email]);
    return $pdo->lastInsertId();
}

// Register system account (with password)
function registerAuthor($pdo, $name, $email, $password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO `author` (`name`, `email`, `password`, `is_admin`) VALUES (:name, :email, :password, 0)';
    query($pdo, $sql, [':name' => $name, ':email' => $email, ':password' => $hashedPassword]);
}

function updateAuthor($pdo, $id, $name, $email, $is_admin)
{
    $sql = 'UPDATE `author` SET `name` = :name, `email` = :email, `is_admin` = :is_admin WHERE `id` = :id';
    query($pdo, $sql, [':name' => $name, ':email' => $email, ':is_admin' => $is_admin, ':id' => $id]);
}

function deleteAuthor($pdo, $id)
{
    query($pdo, 'DELETE FROM `reviews` WHERE `author_id` = :id', [':id' => $id]);
    query($pdo, 'DELETE FROM `contact_messages` WHERE `author_id` = :id', [':id' => $id]);
    query($pdo, 'DELETE FROM `author` WHERE `id` = :id', [':id' => $id]);
}


// -- FILMS CRUD --


function getFilms($pdo)
{
    return query($pdo, 'SELECT `id`, `film_name`, `publish_date` FROM `film` ORDER BY `film_name` ASC')->fetchAll();
}

function getFilmsWithStats($pdo, $search = '')
{
    $sql = 'SELECT f.id, f.film_name, f.publish_date, f.image as thumbnail,
                   COUNT(r.id) as review_count
            FROM film f
            LEFT JOIN reviews r ON f.id = r.film_id';

    $params = [];
    if (!empty($search)) {
        $sql .= ' WHERE f.film_name LIKE :search';
        $params = ['search' => "%$search%"];
    }

    $sql .= ' GROUP BY f.id ORDER BY f.film_name ASC';

    return query($pdo, $sql, $params)->fetchAll();
}

function getFilmByName($pdo, $film_name)
{
    return query($pdo, 'SELECT `id` FROM `film` WHERE `film_name` = :film_name LIMIT 1', [':film_name' => $film_name])->fetch();
}

function insertFilm($pdo, $film_name, $publish_date, $image = null)
{
    $sql = 'INSERT INTO `film` (`film_name`, `publish_date`, `image`) VALUES (:film_name, :publish_date, :image)';
    query($pdo, $sql, [':film_name' => $film_name, ':publish_date' => $publish_date, ':image' => $image]);
    return $pdo->lastInsertId();
}

function deleteFilm($pdo, $id)
{
    query($pdo, 'DELETE FROM `reviews` WHERE `film_id` = :id', [':id' => $id]);
    query($pdo, 'DELETE FROM `film` WHERE `id` = :id', [':id' => $id]);
}

// -- REVIEWS CRUD --

function totalReviews($pdo)
{
    return query($pdo, 'SELECT COUNT(*) FROM reviews')->fetchColumn();
}

function getReviews($pdo, $search = '')
{
    $sql = 'SELECT r.*, a.name AS author_name, f.film_name 
            FROM reviews r
            JOIN author a ON r.author_id = a.id
            JOIN film f ON r.film_id = f.id';

    if (!empty($search)) {
        $sql .= ' WHERE f.film_name LIKE :s1 OR a.name LIKE :s2 OR r.review_text LIKE :s3';
        $params = ['s1' => "%$search%", 's2' => "%$search%", 's3' => "%$search%"];
        return query($pdo, $sql, $params)->fetchAll();
    }
    return query($pdo, $sql . ' ORDER BY r.review_date DESC')->fetchAll();
}

function getReviewById($pdo, $id)
{
    $sql = 'SELECT r.*, a.name AS author_name, a.email AS author_email, f.film_name
            FROM reviews r
            JOIN author a ON r.author_id = a.id
            JOIN film f ON r.film_id = f.id
            WHERE r.id = :id';
    return query($pdo, $sql, [':id' => $id])->fetch();
}

function insertReview($pdo, $text, $author_id, $film_id, $image = null)
{
    $sql = 'INSERT INTO `reviews` (`review_text`, `review_date`, `author_id`, `film_id`, `image`) 
            VALUES (:text, CURDATE(), :auth, :film, :img)';
    query($pdo, $sql, [':text' => $text, ':auth' => $author_id, ':film' => $film_id, ':img' => $image]);
}

function updateReview($pdo, $id, $text, $author_id, $film_id, $image)
{
    $sql = 'UPDATE `reviews` SET `review_text` = :text, `author_id` = :author_id, `film_id` = :film_id, `image` = :image WHERE `id` = :id';
    query($pdo, $sql, [':text' => $text, ':author_id' => $author_id, ':film_id' => $film_id, ':image' => $image, ':id' => $id]);
}

function deleteReview($pdo, $id)
{
    query($pdo, 'DELETE FROM `reviews` WHERE `id` = :id', [':id' => $id]);
}

// -- ADMIN CONTACT --

function insertMessage($pdo, $auth_id, $text)
{
    query($pdo, 'INSERT INTO `contact_messages` (author_id, message_text, date_sent) VALUES (?, ?, CURDATE())', [$auth_id, $text]);
}

function getAllMessages($pdo)
{
    $sql = 'SELECT m.*, a.name AS author_name, a.email AS author_email 
            FROM contact_messages m 
            JOIN author a ON m.author_id = a.id 
            ORDER BY m.date_sent DESC';
    return query($pdo, $sql)->fetchAll();
}

//  -- COMMENT --

// Get all comments for a review
function getCommentsByReviewId($pdo, $review_id)
{
    $sql = 'SELECT c.*, a.name as author_name
            FROM comments c
            JOIN author a ON c.author_id = a.id
            WHERE c.review_id = :review_id
            ORDER BY c.comment_date ASC';
    return query($pdo, $sql, ['review_id' => $review_id])->fetchAll();
}

// Add new comment
function insertComment($pdo, $review_id, $author_id, $comment_text)
{
    $sql = 'INSERT INTO comments (review_id, author_id, comment_text, comment_date)
            VALUES (:review_id, :author_id, :comment_text, NOW())';
    query($pdo, $sql, [
        'review_id' => $review_id,
        'author_id' => $author_id,
        'comment_text' => $comment_text
    ]);
}