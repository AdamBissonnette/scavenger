<!DOCTYPE html>
<html>
    <head>
        <title> Scavenger Backend </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="assets/css/main.css">

        <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js'></script>
    </head>
    <body ng-app="scavengerApp">

        <div ui-view></div>
        
        <script src='https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.13/angular-ui-router.min.js'></script>
        <script src='assets/js/routes.js'></script>
        <script src='assets/js/clueCtrl.js'></script>
        <script src='assets/js/clueList.js'></script>
        <script src='assets/js/answerCtrl.js'></script>
        <script src='assets/js/answerList.js'></script>
    </body>
</html>