	    //Answer Control Forms
	    $scope.answerCtrlFormData = {id : "-1", name : "", value : "", clueid: "-1", storyid: "-1"};

	    $scope.answerCtrlFormData.submit = function(item, event) {
	      var data = {fn: "aeanswer", id : $scope.answerCtrlFormData.id, name : $scope.answerCtrlFormData.name, value : $scope.answerCtrlFormData.value, clueid: $scope.answerCtrlFormData.clueid, storyid : $scope.answerCtrlFormData.storyid}

	      answersList.http(data,
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

	     $scope.answerCtrlFormData.editItem = function(item) {
	      $scope.answerCtrlFormData.id = item.id;
	      $scope.answerCtrlFormData.name = item.name;
	      $scope.answerCtrlFormData.clueid = item.clueid;
	      $scope.answerCtrlFormData.value = item.value;
	      $scope.answerCtrlFormData.storyid = item.storyid;
	     }

	    $scope.hintCtrlFormData.deleteItem = function(item) {
	      var data = {fn: 'deleteEntity', id : item.id, entityName: "Answer"};

	      answersList.http(data,
	          function (response) {
	            delete $scope.answerList[item.id];
	          },
	          function(response){
	            console.log(response);
	          });
	    };

	    //Hint Control Forms
	    $scope.hintCtrlFormData = {id : "-1", name: "", value : "", clue: "-1", priority: "5", storyid: "-1"};

	    $scope.hintCtrlFormData.submit = function(item, event) {
	      var data = {fn: "aehint", id : $scope.hintCtrlFormData.id, name: $scope.hintCtrlFormData.name, value : $scope.hintCtrlFormData.value, clue: $scope.hintCtrlFormData.clue, priority: $scope.hintCtrlFormData.priority, storyid : $scope.hintCtrlFormData.storyid}

	      hintsList.http(data, 
	          function (response) {
	            data.id = response.id;
	            $scope.hintList[data.id] = data;
	          },
	          function (response) {
	            console.log(response);
	          }
	        );

	      $scope.hintCtrlFormData.reset();
	    }

	     $scope.hintCtrlFormData.reset = function() {
	      $scope.hintCtrlFormData.id = -1;
	      $scope.hintCtrlFormData.name = "";
	      $scope.hintCtrlFormData.value = "";
	      $scope.hintCtrlFormData.clue = -1;
	      $scope.hintCtrlFormData.priority = 5;
	     }

	     $scope.hintCtrlFormData.editItem = function(item) {
	      $scope.hintCtrlFormData.id = item.id;
	      $scope.hintCtrlFormData.name = item.name;
	      $scope.hintCtrlFormData.value = item.value;
	      $scope.hintCtrlFormData.clue = item.clue;
	      $scope.hintCtrlFormData.priority = item.priority;
	      $scope.hintCtrlFormData.storyid = item.storyid;
	     }

	    $scope.hintCtrlFormData.deleteItem = function(item) {
	      var data = {fn: 'deleteEntity', id : item.id, entityName: "Hint"};

	      hintsList.http(data, 
	          function (response) {
	            delete $scope.hintList[item.id];
	          },
	          function (response) {
	            console.log(response);
	          }
	        );
	    };