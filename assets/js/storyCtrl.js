angular.module('scavengerApp')
  .controller('storyCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;
    $scope.clues = {};

    var cluesList = ListService;
    var list = ListService;

    cluesList.http({fn: "gclues"},
      function (response) {
          cluesList.setList(response);
          $scope.clues = cluesList.getList();
      },
      function(response){
        console.log(response);
      });

    list.http({fn: "gstories"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.storyList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.storyCtrlFormData = {id : "-1", name : "", description : "", clueid: "-1"};

    $scope.storyCtrlFormData.submit = function(item, event) {
      var data = {fn: "aestory", id : $scope.storyCtrlFormData.id, name : $scope.storyCtrlFormData.name, description : $scope.storyCtrlFormData.description, clueid: $scope.storyCtrlFormData.clueid}

      list.http(data,
          function (response) {
            data.id = response.id;
            $scope.storyList[data.id] = data;
          },
          function(response){
            console.log(response);
          });

      $scope.storyCtrlFormData.reset();
    }

     $scope.storyCtrlFormData.reset = function() {
      $scope.storyCtrlFormData.id = -1;
      $scope.storyCtrlFormData.name = "";
      $scope.storyCtrlFormData.description = "";
      $scope.storyCtrlFormData.clueid = -1;
     }

     $scope.editItem = function(item) {
      $scope.storyCtrlFormData.id = item.id;
      $scope.storyCtrlFormData.name = item.name;
      $scope.storyCtrlFormData.description = item.description;
      $scope.storyCtrlFormData.clueid = item.clueid;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'delstory', id : item.id};

      list.http(data,
          function (response) {
            delete $scope.storyList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"storyid": item.id, "story": item});
    };
}]);

