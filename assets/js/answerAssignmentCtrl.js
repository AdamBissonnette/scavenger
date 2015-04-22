angular.module('scavengerApp')
  .controller('answerAssignmentsCtrl', ['$scope', '$rootScope', '$state', '$http', 'ListService', function($scope, $rootScope, $state, $http, ListService) {

    var cList = ListService;

    $scope.cLoaded = false;

    $scope.answerAssignmentCtrlForm = $state.params.answer;

    console.log

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

            angular.forEach(response, function(resp) {
              resp.checked = false;

              angular.forEach(resp.answers, function(item) {
                console.log(item);
                if($scope.answerAssignmentCtrlForm.id == item.id)
                {
                  resp.checked = true;
                }
    
              });

            });

            cList.setList(response);
            $scope.cList = cList.getList();
            $scope.cLoaded = true;
          },
          function(response){
            console.log(response);
          });
    }

    $scope.assignAA = function(event, item) {
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