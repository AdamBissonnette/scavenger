<div class="col-sm-3">                    
    <h2>Add/Edit Answer</h2>
        <i class='glyphicon-spinner glyphicon-spin glyphicon-large'></i>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="answerCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputNextClue" class="control-label">Next Clue ID</label>
                <select class="form-control" id="inputNextClue" ng-model="answerCtrlFormData.clueid">
                    <option ng-repeat="clue in clues" value="{{clue.id}}">{{clue.id}} | {{clue.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label">Name</label>
                <input ng-model="answerCtrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter name" maxlength="255">
            </div>
            <div class="form-group">
                <label for="inputValue" class="control-label">Value</label>                
                <textarea ng-model="answerCtrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
            </div>
            <div class="form-group">
                <div>
                    <button ng-click="answerCtrlFormData.submit()" class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                        Save
                    </button>
                    <button ng-click="answerCtrlFormData.reset()" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Reset
                    </button>

                    <!-- <pre>{{answerCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>
<div class="col-sm-9">
    <h2>List Answers</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Value</th>
            <th>Next Clue</th>
            <th>Controls</th>
        </tr>
        <tr ng-repeat='item in answerList'>
            <td> {{ item.id }} </td>
            <td> {{ item.name }} </td>
            <td> {{ item.value }} </td>
            <td> {{ item.clueid }} </td>
            <td class="controls">
                <button class="btn btn-success" ng-click='editItem(item)' title="Edit">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </button>

                <button class="btn btn-primary" ng-click='changeState("answerAssignments", item)' title="Assign Clues">
                    <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                </button>

                <button class="btn btn-danger" ng-click='deleteItem(item)' title="Delete">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>