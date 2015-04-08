<div class="col-sm-4">                    
    <h2>Add/Edit Clue</h2>
        <form>
            <div class="form-group">
                <label for="inputID">ID</label>
                <input ng-model="formData.id" type="text" class="form-control" id="inputID" disabled="disabled">
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input ng-model="formData.name" type="text" class="form-control" id="inputName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label for="inputValue">Value</label>
                <input ng-model="formData.value" type="text" class="form-control" id="inputValue" placeholder="Enter value">
            </div>
            <button ng-click="formData.submit()" class="btn btn-primary" type="submit">Add Clue</button>
        </form>
    <p>
        <pre>{{formData}}</pre>
    </p>
</div>
<div class="col-sm-8">
    <h2>List Clues</h2>
    <ul class='lists'>
      <li ng-repeat='item in lists'>
        <span class='item'> {{ item }} </span>
        <button ng-click='deleteItem(item)'>x</button>
      </li>
    </ul>
</div>