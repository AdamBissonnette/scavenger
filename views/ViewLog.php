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
    </tr>
    <tr ng-repeat='item in hintList'>
        <td> {{ item.id }} </td>
        <td> {{ item.from }} </td>
        <td> {{ item.to }} </td>
        <td> {{ item.clue }} </td>
        <td class="controls">
            <button class="btn btn-danger" ng-click='deleteItem(item)' title="Delete">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>