angular.module('scavengerApp')
  .controller('answerCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;
    $scope.clues = {};

    var cluesList = ListService;
    var list = ListService;

    cluesList.http({fn: "getEntities", entityName: "Clue"},
      function (response) {
          cluesList.setList(response);
          $scope.clues = cluesList.getList();
      },
      function(response){
        console.log(response);
      });

    list.http({fn: "getEntities", entityName: "Answer"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          //console.log(response);
          $scope.answerList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.answerCtrlFormData = {id : "-1", name : "", value : "", clueid: "-1"};

    $scope.answerCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, name : $scope.answerCtrlFormData.name, value : $scope.answerCtrlFormData.value, clueid: $scope.answerCtrlFormData.clueid}

      list.http(data,
          function (response) {
            data.id = response.id;
            $scope.answerList[data.id] = data;
          },
          function(response){
            console.log(response);
          });

      $scope.answerCtrlFormData.reset();
    }

     $scope.answerCtrlFormData.reset = function() {
      $scope.answerCtrlFormData.id = -1;
      $scope.answerCtrlFormData.name = "";
      $scope.answerCtrlFormData.value = "";
      $scope.answerCtrlFormData.clueid = -1;
     }

     $scope.editItem = function(item) {
      $scope.answerCtrlFormData.id = item.id;
      $scope.answerCtrlFormData.name = item.name;
      $scope.answerCtrlFormData.clueid = item.clueid;
      $scope.answerCtrlFormData.value = item.value;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Answer"};

      list.http(data,
          function (response) {
            delete $scope.answerList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName, {"answerid": item.id, "answer": item});
    };
}]);

