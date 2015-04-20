angular.module('scavengerApp')
  .controller('answerAssignmentsCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    var cList = ListService;

    $scope.cLoaded = false;

    $scope.answerAssignmentCtrlForm = $state.params.answer;

    $scope.changeState = function(stateName) {
      $state.go(stateName);
    };

    if ($scope.answerAssignmentCtrlForm == null)
    {
        $scope.changeState("answers");
    }
    else
    {
        //Get assignments for current clue              
        cList.http({fn: "gclues"},
          function (response) {
            angular.forEach(response.answers, function(item) {
              item.checked = false;
              if (item.id == $state.params.answer.id)
              {
                item.checked = true;
              }
            });

            cList.setList(response);
            $scope.cList = cList.getList();
            $scope.cLoaded = true;
          },
          function(response){
            console.log(response);
          });
    }

    $scope.assignC = function(event, item) {
        if (event.target.tagName == "INPUT")
        {
          //item.checked = !item.checked;
          var data = {fn: "assignAnswer", clueid: item.id, answerid: $state.params.answer.id, checked: item.checked};
          console.log(data);
          cList.http(data, function(response) {
            //item.checked = !item.checked;
          }, function(response) {console.log(response);});
        }
     };
  }]);