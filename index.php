<!DOCTYPE html>
<html>
    <head>
        <title> Scavenger Backend </title>
        <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js'></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body ng-app="scavengerApp" ng-controller="scavengerCtrl">

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
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#clue">Clue</a></li>
                <!--- <li><a href="#contact">Contact</a></li> --->
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h1>Add/Update Clue</h1>
                    <form>
                        <div class="form-group">
                            <label for="inputID">ID</label>
                            <input ng-model="formData.id" type="text" class="form-control" id="inputID" disabled="disabled">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Name</label>
                            <input ng-model="formData.name" type="text" class="form-control" id="inputName" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="inputValue">Value</label>
                            <input ng-model="formData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value">
                        </div>
                        <button ng-click="formData.submit()" class="btn btn-primary" type="submit">Add Clue</button>
                    </form>
<p>
<pre>{{formData}}</pre>
</p>
                </div>
            </div>

        </div><!-- /.container -->

        <script src='assets/js/scavengerCtrl.js'></script>
    </body>
</html>