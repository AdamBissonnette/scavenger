angular.module('scavengerApp')
  .controller('logCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    $scope.loaded = false;

    var list = ListService;
    var cluesList = ListService;

    cluesList.http({fn: "getEntities", entityName: "Clue"},
      function (response) {
          cluesList.setList(response);
          $scope.clues = cluesList.getList();
      },
      function(response){
        console.log(response);
      });

    var huntsList = ListService;

    huntsList.http({fn: "getEntities", entityName: "Hunt"},
      function (response) {
          huntsList.setList(response);
          $scope.hunts = huntsList.getList();
      },
      function(response){
        console.log(response);
      });

    var answerList = ListService;

    answerList.http({fn: "getEntities", entityName: "Answer"},
      function (response) {
          answerList.setList(response);
          $scope.answers = answerList.getList();
      },
      function(response){
        console.log(response);
      });

    var partyList = ListService;

    partyList.http({fn: "getEntities", entityName: "Party"},
      function (response) {
          partyList.setList(response);
          $scope.parties = partyList.getList();
      },
      function(response){
        console.log(response);
      });

    var storyList = ListService;

    storyList.http({fn: "getEntities", entityName: "Story"},
      function (response) {
          storyList.setList(response);
          $scope.stories = storyList.getList();
      },
      function(response){
        console.log(response);
      });

    var userList = ListService;

    userList.http({fn: "getEntities", entityName: "User"},
      function (response) {
          userList.setList(response);
          $scope.users = userList.getList();
      },
      function(response){
        console.log(response);
      });

    list.http({fn: "getEntities", entityName: "Log"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.list = list.getList();
      },
      function(response){
        console.log(response);
      });

      list.http({fn: "getEntities", entityName: "Log"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.list = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.reloadLogs = function() {
      var list = ListService;
      list.http({fn: "getEntities", entityName: "Log"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.list = list.getList();
      },
      function(response){
        console.log(response);
      });
    };

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Log"};

      list.http(data,
          function (response) {
            delete $scope.list[item.id];
          },
          function(response){
            console.log(response);
          });
    };

    $scope.changeState = function(stateName, item) {
      $state.go(stateName);
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