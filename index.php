<!DOCTYPE html>
<html>
    <head>
        <title> Scavenger Backend </title>
        <script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js'></script>
    </head>
    <body ng-app="scavengerApp" ng-controller="scavengerCtrl">
        <form>
            <div class="input">
                <input type="text" ng-model="formData.value" />
            </div>
            <button ng-click="formData.submit()" type="submit">Add Clue</button>
        </form>

<pre>
{{formData}}
</pre>
        <script src='js/scavengerCtrl.js'></script>
    </body>
</html>