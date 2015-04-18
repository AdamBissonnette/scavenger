<div class="col-sm-3">
    <h2>Clue Assignments</h2>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="inputID" class="col-sm-2 control-label">ID</label>
            <div class="col-sm-10">
                <input ng-model="clueAssignmentCtrlForm.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
        </div>
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input ng-model="clueAssignmentCtrlForm.name" type="text" class="form-control" id="inputName" disabled="disabled" placeholder="Enter name" maxlength="255">
            </div>
        </div>
        <div class="form-group">
            <label for="inputValue" class="col-sm-2 control-label">Value</label>
            <div class="col-sm-10">
                <textarea ng-model="clueAssignmentCtrlForm.value" type="text" class="form-control" id="inputValue" disabled="disabled" placeholder="Enter value" maxlength="255"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-default" ng-click='changeState("clues")'>
                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    Go Back
                </button>
            </div>
        </div>
    </form>

</div>

<div class="col-sm-3">
    <h2>Accepted Answers</h2>
    <div class="panel panel-success">
        <div class="panel-heading">Are correct responses received to this Clue</div>
        <div class="panel-body">
            <div ng-show="aaLoaded">
                <div ng-repeat="item in aaList">
                    <div class="checkbox">
                      <label ng-click="assignAA($event, item)">
                        <input type="checkbox" id="blankCheckbox" value="aa{{item.id}}" ng-checked="item.checked"> {id: {{item.id}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="aaLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-3">
    <h2>Trailing Answers</h2>
    <div class="panel panel-primary">
        <div class="panel-heading">Are received and this Clue is sent as a response</div>
        <div class="panel-body">
            <div ng-show="taLoaded">
                <div ng-repeat="item in taList">
                    <div class="checkbox">
                      <label ng-click="assignTA($event, item)">
                        <input type="checkbox" id="blankCheckbox" value="{{item.id}}" ng-checked="item.checked"> {id: {{item.id}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="taLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-3">
    <h2>Hints</h2>
    <div class="panel panel-warning">
        <div class="panel-heading">Are sent when receiving an incorrect Answer</div>
        <div class="panel-body">    
            <div ng-show="hLoaded">
                <div ng-repeat="item in hList">
                    <div class="checkbox">
                      <label ng-click="assignH($event, item)">
                        <input type="checkbox" id="blankCheckbox" value="{{item.id}}" ng-checked="item.checked"> {id: {{item.id}}, value: {{item.value}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="hLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>