angular.module('scavengerApp')
    .controller('clueCtrl', ['$scope', '$rootScope', '$state', 'ClueListService', '$http', function($scope, $rootScope, $state, ClueListService, $http) {
        $scope.formData = {id : "-1", name: "", value : ""};

        $scope.clueList = ClueListService.getList();

        console.log($scope.clueList);

        $scope.formData.submit = function(item, event) {  
          var index = ($scope.clueList.length + 1);
          $scope.clueList[index].push({id : index, name: $scope.formData.name, value : $scope.formData.value});
          ClueListService.saveList($scope.clueList);
          $scope.formData.reset();

          // var dataObject = $scope.formData;

          //  var responsePromise = $http.post("index.php", dataObject, {});
          //  responsePromise.success(function(dataFromServer, status, headers, config) {
          //     //console.log(dataFromServer.title);
          //  });
          //   responsePromise.error(function(data, status, headers, config) {
          //     alert("Submitting form failed!");
          //  });
         }

         $scope.formData.reset = function() {
          $scope.formData.id = -1;
          $scope.formData.name = "";
          $scope.formData.value = "";
         }

         $scope.editItem = function(item) {
          $scope.formData.id = item.id;
          $scope.formData.name = item.name;
          $scope.formData.value = item.value;
         }

        $scope.deleteItem = function(item) {
          var currentList = $scope.clueList;
          currentList.splice(currentList.indexOf(item), 1);
          ClueListService.saveList($scope.clueList);
        };

    }]);

