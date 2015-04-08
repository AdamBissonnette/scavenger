angular.module('scavengerApp')
    .controller('clueCtrl', ['$scope', '$rootScope', '$state', 'ClueListService', '$http', function($scope, $rootScope, $state, ClueListService, $http) {
        $scope.formData = {id : "-1", name: "", value : ""};

        $scope.lists = ClueListService.getList();

        console.log($scope.lists);

        $scope.formData.submit = function(item, event) {  
           console.log("--> Submitting form");

          $scope.lists.push($scope.clue);
          ListService.saveList($scope.lists);

          var dataObject = $scope.formData;

           var responsePromise = $http.post("index.php", dataObject, {});
           responsePromise.success(function(dataFromServer, status, headers, config) {
              console.log(dataFromServer.title);
           });
            responsePromise.error(function(data, status, headers, config) {
              alert("Submitting form failed!");
           });
         }

        /*$scope.createItem = function() {
          if ($scope.lists[$scope.formData].indexOf($scope.item) === -1 && $scope.item) {
        }
          $scope.item = '';
        };

        $scope.deleteItem = function(item) {
          var currentList = $scope.lists[$scope.formData];
          currentList.splice(currentList.indexOf(item), 1);
          ListService.saveList($scope.lists);
        }; */

    }]);

