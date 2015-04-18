angular.module('scavengerApp')
  .controller('answerCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;

    var list = ListService;

    list.http({fn: "ganswers"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          //console.log(response);
          $scope.answerList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.answerCtrlFormData = {id : "-1", value : "", nextClue: "-1"};

    $scope.answerCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, value : $scope.answerCtrlFormData.value, nextClue: $scope.answerCtrlFormData.nextClue}

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
      $scope.answerCtrlFormData.value = "";
      $scope.answerCtrlFormData.nextClue = -1;
     }

     $scope.editItem = function(item) {
      $scope.answerCtrlFormData.id = item.id;
      $scope.answerCtrlFormData.nextClue = item.nextClue;
      $scope.answerCtrlFormData.value = item.value;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'delanswer', id : item.id};

      list.http(data,
          function (response) {
            delete $scope.answerList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };
}]);

