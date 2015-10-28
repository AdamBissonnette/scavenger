<div class="col-sm-12">
    <h2>Log</h2>
    
    <div class="well">
    <div class="row filters">
        <div class="col-sm-12">
            <h4>Filters</h4>
            <ul class="unstyled">
                <li>
                    <label for="searchFrom" class="control-label">Search From</label>
                    <input id="searchFrom" type="text" class="form-control" ng-model="search.from" />
                </li>
                <li>
                    <label for="searchTo" class="control-label">Search To</label> 
                    <input id="searchTo" type="text" class="form-control" ng-model="search.to" />
                </li>
                <li>
                    <label for="searchValue" class="control-label">Search Value</label> 
                    <input id="searchValue" type="text" class="form-control" ng-model="search.value" />
                </li>
                <li>
                    <label for="searchDirection" class="control-label">Search Directions</label>
                    <select class="form-control" id="searchDirection" ng-model="search.direction">
                        <option value="">Show All</option>
                        <option value="2">Incoming</option>
                        <option value="3">Outgoing</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchType" class="control-label">Search Types</label>
                    <select class="form-control" id="searchType" ng-model="search.type">
                        <option value="">Show All</option>
                        <option value="2">Clue</option>
                        <option value="3">Answer</option>
                        <option value="4">Hint</option>
                        <option value="5">Global</option>
                        <option value="6">Start</option>
                        <option value="7">End</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchMedia" class="control-label">Search Media</label>
                    <select class="form-control" id="searchMedia" ng-model="search.media0">
                        <option value="">Show All</option>
                        <option value="http">Has Media</option>
                        <option value="0">Null</option>
                    </select>
                </li>
            </ul>

        </div>
        <div class="col-sm-12">
            <ul class="unstyled">
                <li>
                    <label for="searchClue" class="control-label">Search Clues</label>
                    <select class="form-control" id="searchClue" ng-model="search.clueid">
                        <option value="">Show All</option>
                        <option ng-repeat='clue in clues | orderObjectBy: "id"' value="{{clue.id}}">{{clue.id}} | {{clue.name}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchAnswer" class="control-label">Search Answers</label>
                    <select class="form-control" id="searchAnswer" ng-model="search.answerid">
                        <option value="">Show All</option>
                        <option ng-repeat='answer in answers | orderObjectBy: "id"' value="{{answer.id}}">{{answer.id}} | {{answer.name}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchStory" class="control-label">Search Stories</label>
                    <select class="form-control" id="searchStory" ng-model="search.storyid">
                        <option value="">Show All</option>
                        <option ng-repeat='story in stories | orderObjectBy: "id"' value="{{story.id}}">{{story.id}} | {{story.name}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchHunt" class="control-label">Search Hunts</label>
                    <select class="form-control" id="searchHunt" ng-model="search.huntid">
                        <option value="">Show All</option>
                        <option ng-repeat='hunt in hunts | orderObjectBy: "id"' value="{{hunt.id}}">{{hunt.id}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchParty" class="control-label">Search Parties</label>
                    <select class="form-control" id="searchParty" ng-model="search.partyid">
                        <option value="">Show All</option>
                        <option ng-repeat='party in parties | orderObjectBy: "id"' value="{{party.id}}">{{party.id}} | {{party.name}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
                <li>
                    <label for="searchUser" class="control-label">Search Users</label>
                    <select class="form-control" id="searchUser" ng-model="search.userid">
                        <option value="">Show All</option>
                        <option ng-repeat='user in users | orderObjectBy: "id"' value="{{user.id}}">{{user.id}} | {{user.name}}</option>
                        <option value="0">Null</option>
                    </select>
                </li>
            </ul>
        </div>
    </div>
    </div>

    <br />

    <table ng-show="loaded" class='table table-bordered table-striped lists'>
    <tr>
        <th>ID</th>
        <th>From</th>
        <th>To</th>
        <th>Value</th>
        <th>Clue</th>
        <th>Answer</th>
        <th>Story</th>
        <th>Hunt</th>
        <th>Party</th>
        <th>User</th>
        <th>Date</th>
        <th>Direction</th>
        <th>Type</th>
        <th>Controls</th>
    </tr>
    <tr ng-repeat='item in list | orderObjectBy: "id" | filter:search:strict'>
        <td> {{ item.id }} </td>
        <td> {{ item.from }} </td>
        <td> {{ item.to }} </td>
        <td> {{ item.value }} </td>
        <td> {{ item.clueid }} </td>
        <td> {{ item.answerid }} </td>
        <td> {{ item.storyid }} </td>
        <td> {{ item.huntid }} </td>
        <td> {{ item.partyid }} </td>
        <td> {{ item.userid }} </td>
        <td> {{ item.date | date: 'yyyy-MM-dd HH:mm:ss' }} </td>
        <td> {{ item.direction }} </td>
        <td> {{ item.type }} </td>
        <td class="controls">
            <button ng-show="item.media0 != null" class="btn btn-default" title="Show image">
                <a href="{{item.media0}}" target="_blank"  class="glyphicon glyphicon-picture">
                </a>
            </button>
            <button class="btn btn-default" ng-click='deleteItem(item)' title="Archive">
                <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
    </table>

    <div class="loading-list" ng-hide="loaded"><i class="glyphicon glyphicon-refresh"></i></div>
</div>