<div class="col-sm-4">
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


                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                    Save Assignments
                </button>
            </div>
        </div>
    </form>

</div>

<div class="col-sm-3">
    <h2>Accepted Answers</h2>
    <p>Are correct responses received to this Clue</p>
    <div ng-show="aaloaded">
        <select ng-model="clueAssignmentCtrlForm.taco" multiple class="form-control">
            <option ng-click="console.log('rawr');">taco 1</option>
            <option>taco 2</option>
            <option>taco 3</option>
        </select>
    </div>

    <div>
        {{$scope.clueAssignmentCtrlFrom.taco}}
    </div>

    <div class="loading-list" ng-hide="aaloaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-3">
    <h2>Trailing Answers</h2>
    <p>Are received and this Clue is sent as a response</p>
    <div ng-show="taloaded">
        <select multiple class="form-control">
            <option>taco</option>
            <option>taco</option>
            <option>taco</option>
        </select>
    </div>

    <div class="loading-list" ng-hide="taloaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>

<div class="col-sm-2">
    <h2>Hints</h2>
    <p>Are sent when receiving an incorrect Answer</p>
    <div ng-show="hloaded">
        <select multiple class="form-control">
            <option>taco</option>
            <option>taco</option>
            <option>taco</option>
        </select>
    </div>

    <div class="loading-list" ng-hide="hloaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>