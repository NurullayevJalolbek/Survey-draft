<?php

declare(strict_types=1);

$admin = new Router();
$surveys = new Surveys();

$admin->get('/login', function() {
    if (isset($_SESSION['username'])) {
        require 'pages/adminPanel.php';
    } else {
        require 'pages/auth/login.php';
    }
});

$admin->post('/login', fn() => (new Router())->login($_POST['username'], $_POST['password']));
$admin->get('/logout', fn() => (new Router())->logout());

$admin->checkAvailability();

$admin->get('/insert', fn() => require "pages/votes_insert.php");
$admin->get('/admin', fn() => require "pages/adminPanel.php");
$admin->get('/home', fn() => require 'pages/home.php');
$admin->get('/votes', fn() => require 'pages/votes.php');
$admin->get('/channels', fn() => require 'pages/channels.php');

$admin->post('/insert', fn() => (new Router())->edit((int)$_POST['editId'], 'survey_variants', $_POST['editName'], 'insert?id=' . $_SESSION['id']));
$admin->post('/home', fn() => (new Router())->edit((int)$_POST['editId'], 'surveys', $_POST['editName'], 'home'));

$admin->get('/home&delete', fn() => (new Router())->delete((int)$_GET['id'], 'surveys', 'home'));
$admin->get('/channels&delete', fn() => (new Router())->delete((int)$_GET['id'], 'channels', 'channels'));
$admin->get("/admin&delete", fn() => (new Router())->delete((int)$_GET['id'], "admin", "admin"));
$admin->get('/votes&delete', fn() => (new Router())->delete((int)$_GET['id'], "survey_variants", "insert?id={$_SESSION['id']}"));

$admin->post('/add&channel', fn() => (new Surveys())->addChannelsId((string)$_POST['channel']));
$admin->post('/add', fn() => (new Surveys())->addSurveys($_POST['surveys'], $_POST['desc'], $_POST['expired_at']));
$admin->post('/admin', fn() => (new Surveys())->addNewAdmin($_POST['username'], $_POST['password'], (int)$_POST['userId']));
$admin->post('/add&votes', fn() => (new Surveys())->addSurveryVariants($_POST['survey_insert'], $_SESSION['id']));

$admin->notFount();