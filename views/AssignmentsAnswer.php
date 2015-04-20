<div class="col-sm-3">                    
    <h2>Answer</h2>
        <i class='glyphicon-spinner glyphicon-spin glyphicon-large'></i>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="answerCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputNextClue" class="control-label">Next Clue ID</label>
                <input ng-model="answerCtrlFormData.clueid" type="text" class="form-control" id="inputNextClue" disabled="disabled" maxlength="255" />
            </div>
            <div class="form-group">
                <label for="inputValue" class="control-label">Value</label>                
                <textarea ng-model="answerCtrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
            </div>
            <div class="form-group">
                <div>
                    <button class="btn btn-default" ng-click='changeState("answers")'>
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                        Go Back
                    </button>
                    <!-- <pre>{{answerCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>

<div class="col-sm-3">
    <h2>Favorable To...</h2>
    <br />
    <div class="panel panel-success">
        <div class="panel-heading">These are clues that will accept this Answer as correct </div>
        <div class="panel-body">
            <div ng-show="cLoaded">
                <div ng-repeat="item in cList">
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