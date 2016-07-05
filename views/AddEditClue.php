<div class="col-sm-3 aeform">
    <div class="sidebar-wrapper">                   
    <h2>Add/Edit Clue</h2>
    <form id="clueForm" class="form-horizontal col-sm-12">
        <div class="form-group">
            <label for="inputClueID" class="control-label">ID</label>
            <input ng-model="clueCtrlFormData.id" type="text" class="form-control" id="inputClueID" disabled="disabled" maxlength="10">
        </div>
        <div class="form-group">
            <label for="inputClueName" class="control-label">Name</label>
            <input ng-model="clueCtrlFormData.name" type="text" class="form-control" id="inputClueName" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="inputClueValue" class="control-label">Value</label>
            <textarea ng-model="clueCtrlFormData.value" type="text" class="form-control" id="inputClueValue" placeholder="Enter value"></textarea>
        </div>
        <div class="form-group">
            <label for="inputClueName" class="control-label">From Number</label>
            <input ng-model="clueCtrlFormData.fromNumber" type="text" class="form-control" id="inputFromNumber" placeholder="Enter from number">
        </div>
        <div class="form-group">
            <label for="inputClueStory" class="control-label">Story ID</label>
            <select class="form-control" id="inputClueStory" ng-model="clueCtrlFormData.storyid">
                <option value="0"></option>
                <option ng-repeat='story in navStories | orderObjectBy: "id"' value="{{story.id}}">{{story.id}} | {{story.name}}</option>
            </select>
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

            </div>
        </div>
        
        <div class="well">Char Count: {{clueCtrlFormData.value.length}}<br /> SMS Count: {{clueCtrlFormData.value.length / 160}}</div>
    </form>

        <hr />
    <h4>Secret Codes</h4>
    <ul>
        <li>^texty text == SMS Only</li>
        <li>^Øurl.jpg == MMS Only </li>
        <li>^texty textØurl.jpg == MMS & SMS</li>
        <li style="max-width: 200px;">[a1a2,10,Default Text] == Source value from answer #1 or #2 at a max of 10 characters and if no value is found then we just put in "Default Text"</li>
    </ul>
    </div>
</div>
<div class="col-sm-9 aelist">
    <h2>List Clues</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Value</th>
        <th>From Number</th>
        <th>Is MMS</th>
        <th>Char Count</th>
        <th>SMS Count</th>
        <th>Arrived At By (Answer IDs)</th>
        <th>Accepts (Answer IDs)</th>
        <th>Story</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in clueList | orderObjectBy: "id" | filter:nav:strict'>
        <td>{{ item.id }}</td>
        <td>{{ item.name }}</td>
        <td class="value">{{ item.value }}</td>
        <td>{{ item.fromNumber }}</td>
        <td>{{item.value.indexOf("Ø") > -1}}</td>
        <td>{{item.value.length}}</td>
        <td>{{item.value.length / 160}}</td>
        <td><span ng-repeat="answer in item.trailings">{{answer.id}} - {{answer.name}} </span></td>
        <td><span ng-repeat="answer in item.answers">[{{answer.id}} - {{answer.name}}]</span></td>
        <td>{{item.storyid}}</td>
        <td class="controls">
            <button id="c{{item.id}}edit" class="btn btn-success" ng-click='clueCtrlFormData.editItem(item)' title="Edit">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </button>

            <button id="c{{item.id}}link" class="btn btn-primary" ng-click='clueCtrlFormData.changeState("app.clueAssignments", item)' title="Assign Answers / Hints">
                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
            </button>
            
            <button id="c{{item.id}}del" class="btn btn-danger" ng-click='clueCtrlFormData.deleteItem(item)' title="Delete">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>