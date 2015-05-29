<div class="col-sm-3">                    
    <h2>Add/Edit Hunt</h2>
        <form class="form-horizontal col-sm-12">
            <div class="form-group">
                <label for="inputID" class="control-label">ID</label>
                <input ng-model="huntCtrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputStart" class="control-label">Start</label>
                <input ng-model="huntCtrlFormData.start" type="text" class="form-control" id="inputStart" placeholder="Start Date" maxlength="255">
            </div>
            <div class="form-group">
               <label for="inputEnd" class="control-label">End</label>
                <input ng-model="huntCtrlFormData.end" type="text" class="form-control" id="inputEnd" placeholder="End Date" maxlength="255">
            </div>
            <div class="form-group">
                <label for="inputStory" class="control-label">Story ID</label>
                <select class="form-control" id="inputStory" ng-model="huntCtrlFormData.story">
                    <option ng-repeat="story in stories" value="{{story.id}}">{{story.id}} | {{story.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputParty" class="control-label">Party ID</label>
                <select class="form-control" id="inputParty" ng-model="huntCtrlFormData.party">
                    <option ng-repeat="party in parties" value="{{party.id}}">{{party.id}} | {{party.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputClue" class="control-label">Party ID</label>
                <select class="form-control" id="inputClue" ng-model="huntCtrlFormData.clue">
                    <option ng-repeat="clue in clues" value="{{clue.id}}">{{clue.id}} | {{clue.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <div class="">
                    <button ng-click="huntCtrlFormData.submit()" class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>
                        Save
                    </button>
                    <button ng-click="huntCtrlFormData.reset()" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span>
                        Reset
                    </button>

                    <!-- <pre>{{huntCtrlFormData}}</pre> -->
                </div>
            </div>
        </form>
</div>
<div class="col-sm-9">
    <h2>List Hunts</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Start</th>
        <th>End</th>
        <th>Story</th>
        <th>Party</th>
        <th>Current Clue</th>
        <th>Hints Used</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in hintList'>
        <td> {{ item.id }} </td>
        <td> {{ item.start }} </td>
        <td> {{ item.end }} </td>
        <td> {{ item.story }} </td>
        <td> {{ item.party }} </td>
        <td> {{ item.clue }} </td>
        <td> {{ item.hintsUsed }} </td>
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