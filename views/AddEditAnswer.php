<div class="col-sm-4">                    
    <h2>Add/Edit Answer</h2>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputID" class="col-sm-2 control-label">ID</label>
                <div class="col-sm-10">
                    <input ng-model="answerCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <label for="inputValue" class="col-sm-2 control-label">Value</label>
                <div class="col-sm-10">
                    <textarea ng-model="answerCtrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="inputNextClue" class="col-sm-2 control-label">NextClue</label>
                <div class="col-sm-10">
                    <input ng-model="answerCtrlFormData.nextClue" type="text" class="form-control" id="inputNextClue" placeholder="Pick next clue id" maxlength="255" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
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
<div class="col-sm-8">
    <h2>List Answers</h2>
    <table class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Value</th>
        <th>Next Clue</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in answerList'>
        <td> {{ item.id }} </td>
        <td> {{ item.value }} </td>
        <td> Next Clue </td>
        <td class="controls">
            <button class="btn btn-success" ng-click='editItem(item)' title="Edit">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>
            <button class="btn btn-danger" ng-click='deleteItem(item)' title="Delete">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </ul>
</div>