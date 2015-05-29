<div class="col-sm-12">
    <h2>Log</h2>
    <br />
    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>From</th>
        <th>To</th>
        <th>Value</th>
        <th>Date</th>
        <th>Direction</th>
        <th>Type</th>
        <th>Data</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in list'>
        <td> {{ item.id }} </td>
        <td> {{ item.from }} </td>
        <td> {{ item.to }} </td>
        <td> {{ item.value }} </td>
        <td> {{ item.date }} </td>
        <td> {{ item.direction }} </td>
        <td> {{ item.type }} </td>
        <td> data </td>
        <td class="controls">
            <button class="btn btn-default" ng-click='deleteItem(item)' title="Archive">
                <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>