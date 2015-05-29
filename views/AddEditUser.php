<div class="col-sm-3">                    
    <h2>Add/Edit User</h2>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="userCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label">Name</label>
                <input ng-model="userCtrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter name" maxlength="255">
            </div>
            <div class="form-group">
                <label for="inputEmail" class="control-label">Email</label>
                <input ng-model="userCtrlFormData.email" type="text" class="form-control" id="inputEmail" placeholder="Enter email" maxlength="255">
            </div>
            <div class="form-group">
                <label for="inputPhone" class="control-label">Phone</label>
                <input ng-model="userCtrlFormData.phone" type="text" class="form-control" id="inputPhone" placeholder="Format like: +13063704254" maxlength="255">
            </div>

            <div class="form-group">
                <label for="inputCurClue" class="control-label">Next Clue ID</label>
                <select class="form-control" id="inputCurClue" ng-model="userCtrlFormData.clueid">
                    <option></option>
                    <option ng-repeat="clue in clues" value="{{clue.id}}">{{clue.id}} | {{clue.name}}</option>
                </select>
            </div>

            <div class="form-group">
                <div class="">
                    <button ng-click="userCtrlFormData.submit()" class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                        Save
                    </button>
                    <button ng-click="userCtrlFormData.reset()" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Reset
                    </button>

                    <!-- <pre>{{userCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>
<div class="col-sm-9">
    <h2>List Users</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Registration Date</th>
        <th>Current Clue</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in userList' | orderObjectBy: "id">
        <td> {{ item.id }} </td>
        <td> {{ item.name }} </td>
        <td> {{ item.email }} </td>
        <td> {{ item.phone }} </td>
        <td> {{ item.date | date: 'yyyy-MM-dd HH:mm:ss' }} </td>
        <td> {{ item.clueid}} </td>
        <td class="controls">
            <button class="btn btn-success" ng-click='editItem(item)' title="Edit">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>
            
            <button class="btn btn-danger" ng-click='deleteItem(item)' title="Delete">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>