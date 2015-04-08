angular.module('scavengerApp', [])
    .controller('scavengerCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.formData = {"id" : "-1", "value" : "", "name": ""};


        $scope.formData.submit = function(item, event) {
           console.log("--> Submitting form");
           var dataObject = $scope.formData;

           var responsePromise = $http.post("index.php", dataObject, {});
           responsePromise.success(function(dataFromServer, status, headers, config) {
              console.log(dataFromServer.title);
           });
            responsePromise.error(function(data, status, headers, config) {
              alert("Submitting form failed!");
           });
         }

    }]);

