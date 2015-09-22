<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */
function getConnection() {
        require '../passwords.php';
        $dbhost = $mysql_db_server;
        $dbuser = $mysql_db_login;
        $dbpass = $mysql_db_password;
        $dbname = $mysql_db_name;
        $dbh = new PDO ( "mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass );
        $dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $dbh;
}
/****************************************************
 *                                                  *
 *                   GET ROUTE                      *
 *                                                  *
 ****************************************************
 */
// GET route
$app->get(
    '/',
    function () {
        getConnection();
        echo 'This is a GET route';
    }
);
// GET all infos from the database
$app->get ( '/infos/', function () {
        $sql = "select * FROM infos";
        try {
                $db = getConnection ();
                $stmt = $db->query ( $sql );
                $employees = $stmt->fetchAll ( PDO::FETCH_OBJ );
                $db = null;
                echo json_encode ( $employees );
        } catch ( PDOException $e ) {
        }
} );
// GET info from the database by sid
$app->get ( '/infos/id/:id', function ($id) {
        $sql = "select * FROM infos WHERE id=:id";
        try {
                $db = getConnection ();
                $stmt = $db->prepare ( $sql );
                $stmt->bindParam ( "id", $id );
                $stmt->execute ();
                $infos = $stmt->fetchAll ( PDO::FETCH_OBJ );
                $db = null;
                if ($infos) {
                        echo json_encode ( $infos );
                } else {
                }
        } catch ( PDOException $e ) {
        }
} );
// GET all infos from the database by status
$app->get ( '/infos/status/:status', function ($status) {
        $sql = "select * FROM infos WHERE status=:status";
        try {
                $db = getConnection ();
                $stmt = $db->prepare ( $sql );
                $stmt->bindParam ( "status", $status );
                $stmt->execute ();
                $infos = $stmt->fetchAll ( PDO::FETCH_OBJ );
                $db = null;
                if ($infos) {
                        echo json_encode ( $infos );
                } else {
                }
        } catch ( PDOException $e ) {
        }
} );
// GET all infos from the database by notation
$app->get ( '/infos/notation/:notation', function ($notation) {
        $sql = "select * FROM infos WHERE notation=:notation";
        try {
                $db = getConnection ();
                $stmt = $db->prepare ( $sql );
                $stmt->bindParam ( "notation", $notation );
                $stmt->execute ();
                $infos = $stmt->fetchAll ( PDO::FETCH_OBJ );
                $db = null;
                if ($infos) {
                        echo json_encode ( $infos );
                } else {
                }
        } catch ( PDOException $e ) {
        }
} );

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
