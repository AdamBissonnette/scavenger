<div class="col-sm-3">                    
    <h2>Add/Edit Clue</h2>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="clueCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label">Name</label>
                <input ng-model="clueCtrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="inputValue" class="control-label">Value</label>
                <textarea ng-model="clueCtrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value"></textarea>
            </div>
            <div class="form-group">
                <div class="">
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

        <hr />
        <h4>Secret Codes</h4>
        <ul>
            <li>^ == SMS</li>
            <li>^Ø == MMS</li>
        </ul>
</div>
<div class="col-sm-9">
    <h2>List Clues</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Value</th>
        <th>Arrived At By (Answer IDs)</th>
        <th>Accepts (Answer IDs)</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in clueList'>
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td class="value">{{ item.value }}</td>
        <td><span ng-repeat="answer in item.trailings">{{answer.id}} </span></td>
        <td><span ng-repeat="answer in item.answers">{{answer.id}} </span></td>
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