<div class="col-sm-4">                    
    <h2>Add/Edit Clue</h2>
        <form>
            <div class="form-group">
                <label for="inputID">ID</label>
                <input ng-model="formData.id" type="text" class="form-control" id="inputID" disabled="disabled" maxlength="10">
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input ng-model="formData.name" type="text" class="form-control" id="inputName" placeholder="Enter name" maxlength="255">
            </div>
            <div class="form-group">
                <label for="inputValue">Value</label>
                <textarea ng-model="formData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value" maxlength="255"></textarea>
            </div>
            <button ng-click="formData.submit()" class="btn btn-primary" type="submit">Save Clue</button>
            <button ng-click="formData.reset()" class="btn btn-default" type="submit">reset</button>
        </form>
    <p>
        <pre>{{formData}}</pre>
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
            <button class="btn btn-error" ng-click='deleteItem(item)'>delete</button>
        </td>
    </tr>
    </ul>
</div>