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
      <a class="navbar-brand" href="#">Scavenger Backend</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a ui-sref="clues" href="#">Clues</a></li>
        <li><a ui-sref="answers" href="#">Answers</a></li>
        <li><a ui-sref="hints" href="#">Hints</a></li>
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
        <script src='assets/js/listService.js'></script>
        <script src='assets/js/clueAssignmentsCtrl.js'></script>        
    </body>
</html>