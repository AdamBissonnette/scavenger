<div class="col-sm-3">
    <h2>This Clue...</h2>
    <form class="form-horizontal col-sm-12">
        <div class="form-group">
            <label for="inputID" class="control-label">ID</label>
            <input ng-model="clueAssignmentCtrlForm.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">   
        </div>
        <div class="form-group">
            <label for="inputName" class="control-label">Name</label>
            <input ng-model="clueAssignmentCtrlForm.name" type="text" class="form-control" id="inputName" disabled="disabled" placeholder="Enter name" maxlength="255"> 
        </div>
        <div class="form-group">
            <label for="inputValue" class="control-label">Value</label>
            <textarea ng-model="clueAssignmentCtrlForm.value" type="text" class="form-control" id="inputValue" disabled="disabled" placeholder="Enter value" maxlength="255"></textarea>    
        </div>
        <div class="form-group">
            <div class="">
                <button class="btn btn-default" ng-click='changeState("app.clues")'>
                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    Go Back
                </button>
            </div>
        </div>
    </form>

</div>

<div class="col-sm-3">
    <h2>Accepts</h2>
    <br />
    <div class="panel panel-success">
        <div class="panel-heading">The Answers selected here as correct</div>
        <div class="panel-body">
            <div ng-show="aaLoaded">
                <div ng-repeat="item in aaList">
                    <div class="checkbox">
                      <label ng-click="assignAA($event, item)">
                        <input type="checkbox" ng-model="item.checked"> {id: {{item.id}}, name: {{item.name}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="aaLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-3">
    <h2>Is Arrived At By</h2>
    <br />
    <div class="panel panel-primary">
        <div class="panel-heading">The Answers selected here when it is accepted by another clue</div>
        <div class="panel-body">
            <div ng-show="taLoaded">
                <div ng-repeat="item in taList">
                    <div class="checkbox">
                      <label ng-click="assignTA($event, item)">
                        <input type="checkbox" ng-model="item.checked"> {id: {{item.id}}, name: {{item.name}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="taLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-3">
    <h2>Gives Hints</h2>
    <br />
    <div class="panel panel-warning">
        <div class="panel-heading">When it receives an incorrect Answer</div>
        <div class="panel-body">    
            <div ng-show="hLoaded">
                <div ng-repeat="item in hList">
                    <div class="checkbox">
                      <label ng-click="assignH($event, item)">
                        <input type="checkbox" ng-model="item.checked"> {id: {{item.id}}, name: {{item.name}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="hLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>