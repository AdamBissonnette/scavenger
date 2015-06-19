<?php
ob_start();
if (!isset($_SERVER['PHP_AUTH_USER']) || $_COOKIE['isin'] != "1") {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    setcookie ("isin", "1");
    die('<a href="http://www.jabberwocky.com/carroll/walrus.html">Here is the secret url</a>');
} 
else {
    if($_SERVER['PHP_AUTH_USER'] == "USER" &&  $_SERVER['PHP_AUTH_PW']== "PASSWORD") {
        $logout = "<a href='".$_SERVER['PHP_SELF']."?action=logout'>logout</a>";
    }
    else {
        setcookie ("isin", "", time() - 3600);
        $url=$_SERVER['PHP_SELF'];
        header("location: $url");
    }
    if (isset($_GET['action']))
    {

        if($_GET['action'] == "logout") {
            setcookie ("isin", "", time() - 3600);
            $url=$_SERVER['PHP_SELF'];
            header("location: $url");
        }
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Scavenger Backend </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="assets/css/main.css">

        <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js'></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body ng-app="scavengerApp">
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" ui-sref="app.clues" href="#">Scavenger Backend</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a ui-sref="app.stories" href="#">Stories</a></li>
        <li><a ui-sref="app.clues" href="#">Clues</a></li>
        <li><a ui-sref="app.answers" href="#">Answers</a></li>
        <li><a ui-sref="app.hints" href="#">Hints</a></li>
        <li><a ui-sref="app.parties" href="#">Parties</a></li>
        <li><a ui-sref="app.users" href="#">Users</a></li>
        <li><a ui-sref="app.hunts" href="#">Hunts</a></li>
        <li><a ui-sref="app.twiMLTests" href="#">Testing</a></li>
        <li><a ui-sref="app.log" href="#">Logs</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><?php echo $logout; ?></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
<div class="row">
        <div ui-view></div>
</div>
</div>   
        <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.13/angular-ui-router.min.js'></script>
        <script src='assets/js/routes.js'></script>
        <script src='assets/js/clueCtrl.js'></script>
        <script src='assets/js/answerCtrl.js'></script>
        <script src='assets/js/hintCtrl.js'></script>
        <script src='assets/js/huntCtrl.js'></script>
        <script src='assets/js/storyCtrl.js'></script>
        <script src='assets/js/userCtrl.js'></script>
        <script src='assets/js/partyCtrl.js'></script>
        <script src='assets/js/listService.js'></script>
        <script src='assets/js/clueAssignmentsCtrl.js'></script>
        <script src='assets/js/answerAssignmentCtrl.js'></script>
        <script src='assets/js/twiMLTests.js'></script>
        <script src='assets/js/logCtrl.js'></script>
    </body>
</html>