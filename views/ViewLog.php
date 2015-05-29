<div class="col-sm-12">
    <h2>Log</h2>
    <p>
        <strong>Direction</strong> (2 = Incoming, 3 = Outgoing) |
        <strong>Type</strong> (2 = Clue, 3 = Answer, 4 = Hint, 5 = Global, 6 = Start, 7 = End)
    </p>
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
    <tr ng-repeat='item in list | orderObjectBy: "id"'>
        <td> {{ item.id }} </td>
        <td> {{ item.from }} </td>
        <td> {{ item.to }} </td>
        <td> {{ item.value }} </td>
        <td> {{ item.date | date: 'yyyy-MM-dd HH:mm:ss' }} </td>
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