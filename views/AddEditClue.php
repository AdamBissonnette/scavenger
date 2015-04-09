<div class="col-sm-4">                    
    <h2>Add/Edit Clue</h2>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="inputID" class="col-sm-2 control-label">ID</label>
                <div class="col-sm-10">
                    <input ng-model="ctrlFormData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input ng-model="ctrlFormData.name" type="text" class="form-control" id="inputName" placeholder="Enter name" maxlength="255">
                </div>
            </div>
            <div class="form-group">
                <label for="inputValue" class="col-sm-2 control-label">Value</label>
                <div class="col-sm-10">
                    <textarea ng-model="ctrlFormData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button ng-click="ctrlFormData.submit()" class="btn btn-primary" type="submit">Save Clue</button>
                    <button ng-click="ctrlFormData.reset()" class="btn btn-default" type="submit">reset</button>
                </div>
            </div>
        </form>
    <p>
        <pre>{{ctrlFormData}}</pre>
    </p>
</div>
<div class="col-sm-8">
    <h2>List Clues</h2>
    <table class='table table-bordered table-striped lists'>
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
        <td>
            <button class="btn btn-success" ng-click='editItem(item)'>edit</button>
            <button class="btn btn-danger" ng-click='deleteItem(item)'>delete</button>
        </td>
    </tr>
    </ul>
</div>