angular.module('scavengerApp')
  .controller('storyCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

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

    list.http({fn: "getEntities", entityName: "Story"},
      function (response) {
          list.setList(response);
          $scope.loaded = true;
          $scope.storyList = list.getList();
      },
      function(response){
        console.log(response);
      });

    $scope.storyCtrlFormData = {id : "-1", name : "", description : "", clueid: "-1", code: "", maxUsers: "-1", end: "", hint: "", type: "0"};

    $scope.storyCtrlFormData.submit = function(item, event) {
      var data = {fn: "aestory",
       id : $scope.storyCtrlFormData.id,
       name : $scope.storyCtrlFormData.name,
       description : $scope.storyCtrlFormData.description,
       clueid: $scope.storyCtrlFormData.clueid,
       code: $scope.storyCtrlFormData.code,
       maxUsers: $scope.storyCtrlFormData.maxUsers,
       end: $scope.storyCtrlFormData.end,
       hint: $scope.storyCtrlFormData.hint,
       type: $scope.storyCtrlFormData.type}

      list.http(data,
          function (response) {
            data.id = response.id;
            $scope.storyList[data.id] = data;
            $rootScope.navStories = $scope.storyList;
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
      $scope.storyCtrlFormData.code = "";
      $scope.storyCtrlFormData.maxUsers = -1;
      $scope.storyCtrlFormData.end = "";
      $scope.storyCtrlFormData.hint = "";
      $scope.storyCtrlFormData.type = 0;
     }

     $scope.editItem = function(item) {
      $scope.storyCtrlFormData.id = item.id;
      $scope.storyCtrlFormData.name = item.name;
      $scope.storyCtrlFormData.description = item.description;
      $scope.storyCtrlFormData.clueid = item.clueid;
      $scope.storyCtrlFormData.code = item.code;
      $scope.storyCtrlFormData.maxUsers = item.maxUsers;
      $scope.storyCtrlFormData.end = item.end;
      $scope.storyCtrlFormData.hint = item.hint;
      $scope.storyCtrlFormData.type = item.type;
     }

    $scope.deleteItem = function(item) {
      var data = {fn: 'deleteEntity', id : item.id, entityName: "Story"};

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

