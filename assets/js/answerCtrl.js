angular.module('scavengerApp')
  .controller('answerCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;

    if ($scope.clueList == null)
    {
      $scope.clueList = {};
      var cluesList = ListService;

      cluesList.http({fn: "getEntities", entityName: "Clue"},
        function (response) {
            cluesList.setList(response);
            $scope.clueList = cluesList.getList();
        },
        function(response){
          console.log(response);
        });

    }

    var list = ListService;

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

    $scope.answerCtrlFormData = {id : "-1", name : "", value : "", to : "", clueid: "-1", storyid: "-1"};

    $scope.answerCtrlFormData.submit = function(item, event) {
      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, name : $scope.answerCtrlFormData.name, value : $scope.answerCtrlFormData.value, to : $scope.answerCtrlFormData.to, clueid: $scope.answerCtrlFormData.clueid, storyid : $scope.answerCtrlFormData.storyid}

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
      $scope.answerCtrlFormData.to = "";
      $scope.answerCtrlFormData.clueid = -1;
     }

     $scope.answerCtrlFormData.editItem = function(item) {
      $scope.answerCtrlFormData.id = item.id;
      $scope.answerCtrlFormData.name = item.name;
      $scope.answerCtrlFormData.clueid = item.clueid;
      $scope.answerCtrlFormData.value = item.value;
      $scope.answerCtrlFormData.to = item.to;
      $scope.answerCtrlFormData.storyid = item.storyid;
     }

    $scope.answerCtrlFormData.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Answer"};

      list.http(data,
          function (response) {
            delete $scope.answerList[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.answerCtrlFormData.changeState = function(stateName, item) {
      $state.go(stateName, {"answerid": item.id, "answer": item});
    };
}]).filter('orderObjectBy', function(){
 return function(input, attribute) {
    if (!angular.isObject(input)) return input;

    var array = [];
    for(var objectKey in input) {
        array.push(input[objectKey]);
    }

    array.sort(function(a, b){
        a = parseInt(a[attribute]);
        b = parseInt(b[attribute]);
        return a - b;
    });
    return array;
 }
});

