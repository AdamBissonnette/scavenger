<div class="col-sm-3">
    <div class="sidebar-wrapper">              
    <h2>This Answer...</h2>
        <i class='glyphicon-spinner glyphicon-spin glyphicon-large'></i>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="answerAssignmentCtrlForm.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputNextClue" class="control-label">Next Clue ID</label>
                <input type="text" class="form-control" id="inputNextClue" ng-model="answerAssignmentCtrlForm.clueid" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="inputValue" class="control-label">Value</label>                
                <textarea ng-model="answerAssignmentCtrlForm.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255" disabled="disabled"></textarea>
            </div>
            <div class="form-group">
                <div>
                    <button  ng-click='changeState("app.answers")' class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Back to Answers
                    </button>

                    <!-- <pre>{{answerAssignmentCtrlForm}}</pre> -->
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-sm-3">
    <h2>Is Acceptable To</h2>
    <br />
    <div class="panel panel-success">
        <div class="panel-heading">The clues selected here and will allow the user to continue to the Answers' "NextClue"</div>
        <div class="panel-body">
            <div ng-show="cLoaded">
                <div ng-repeat='item in cList | orderObjectBy: "id"'>
                    <div class="checkbox">
                      <label ng-click="assignAA($event, item)">
                        <input type="checkbox" ng-model="item.checked"> {id: {{item.id}}, name: {{item.name}}}
                      </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loading-list" ng-hide="cLoaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>