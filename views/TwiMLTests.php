<div class="col-sm-3">                    
    <h2>Tests</h2>

    <form action="PhpHandler.php" method="get" target="resultsFrame">
        <div class="form-group">
            <label for="From" class="control-label">Phone</label>
            <input type="text" class="form-control" id="From" name="From" value="(306) 370-4254">
        </div>
        <div class="form-group">
            <label for="Body" class="control-label">Message</label>
            <textarea id="Body" name="Body" class="form-control"></textarea>
        </div>
        <input type="hidden" name="To" value="(306) tst-test" />
        <div class="form-group">
            <div>
                <input type="submit" class="btn btn-primary" />
                <input type="reset" class="btn btn-default" />
            </div>
        </div>
    </form>

    <hr />
    <h4>Global Commands</h4>
    <ul>
        <li><strong>Start</strong> - if the current clue is null this will set it to the first in the active "Story"</li>
        <li><strong>Restart</strong> - will set a non-null current clue to the first in the active "Story"</li>
        <li><strong>Clue</strong> - will output the value of the current clue</li>
    </ul>

    <h4>Preset Tests</h4>
    <ul>
        <li><a target="resultsFrame" href="PhpHandler.php?Body=start&From=(306)%20370-4254&To=(306)%20tst-test">Sent SMS "Start" - SMS Reply</a></li>
        <li><a target="resultsFrame" href="PhpHandler.php?Body=restart&From=(306)%20370-4254&To=(306)%20tst-test">Sent SMS "Restart" - SMS Reply</a></li>
        <li><a target="resultsFrame" href="PhpHandler.php?Body=clue&From=(306)%20370-4254&To=(306)%20tst-test">Sent SMS "Clue" - MMS Reply</a></li>
        <li><a target="resultsFrame" href="PhpHandler.php?Body=aaa&From=(306)%20999-9999&To=(306)%20tst-test">Unregistered messages the app</a></li>
    </ul>
</div>
<div class="col-sm-9">
    <h2>Results</h2>
    <iframe class="col-sm-12" style="height: 500px;" name="resultsFrame"></iframe>
</div>