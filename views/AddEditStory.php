<div class="col-sm-3">                    
    <h2>Add/Edit Story</h2>
        <i class='glyphicon-spinner glyphicon-spin glyphicon-large'></i>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="storyCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label">Name</label>                
                <input ng-model="storyCtrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter Name" maxlength="255"></textarea>
            </div>
            <div class="form-group">
                <label for="inputDescription" class="control-label">Description</label>                
                <textarea ng-model="storyCtrlFormData.description" type="text" class="form-control" id="inputDescription" placeholder="Enter description" maxlength="255"></textarea>
            </div>
            <div class="form-group">
                <label for="inputFirstClue" class="control-label">First Clue ID</label>
                <select class="form-control" id="inputFirstClue" ng-model="storyCtrlFormData.clueid">
                    <option ng-repeat="clue in clues" value="{{clue.id}}">{{clue.id}} | {{clue.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <div>
                    <button ng-click="storyCtrlFormData.submit()" class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                        Save
                    </button>
                    <button ng-click="storyCtrlFormData.reset()" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Reset
                    </button>

                    <!-- <pre>{{storyCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>
<div class="col-sm-9">
    <h2>List Stories</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>First Clue</th>
            <th>Controls</th>
        </tr>
        <tr ng-repeat='item in storyList' | orderObjectBy: "id">
            <td> {{ item.id }} </td>
            <td> {{ item.name }} </td>
            <td> {{ item.clueid }} </td>
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