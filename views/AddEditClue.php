<div class="col-sm-4">                    
    <h2>Add/Edit Clue</h2>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputID" class="col-sm-2 control-label">ID</label>
                <div class="col-sm-10">
                    <input ng-model="clueCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input ng-model="clueCtrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter name" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label for="inputValue" class="col-sm-2 control-label">Value</label>
                <div class="col-sm-10">
                    <textarea ng-model="clueCtrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button ng-click="clueCtrlFormData.submit()" class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                        Save
                    </button>
                    <button ng-click="clueCtrlFormData.reset()" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Reset
                    </button>

                    <!-- <pre>{{clueCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>
<div class="col-sm-8">
    <h2>List Clues</h2>
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Value</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in clueList'>
        <td> {{ item.id }} </td>
        <td> {{ item.name }} </td>
        <td> {{ item.value }} </td>
        <td class="controls">
            <button class="btn btn-success" ng-click='editItem(item)' title="Edit">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>

            <button class="btn btn-primary" ng-click='changeState("clueAssignments", item)' title="Assign Answers / Hints">
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