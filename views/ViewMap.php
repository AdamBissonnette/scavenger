<div class="storymap">
<div class="col-sm-12">
	<div class="map-controls">
		<form class="form-horizontal">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClue">Add Clue</button>
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAnswer">Add Answer</button>
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addHint">Add Hint</button> |
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addClue">Save Layout</button>
			<div class="btn btn-default" href="#">
				Load Layout&nbsp;
				<select>
					<option>Layout 1</option>
				</select>
			</div> |
			<button type="button" class="btn btn-default" ng-click='loadMap()'>Reload Map</button>
		</form>
	</div>
</div>
<div id="cy" class="col-sm-12"></div>

<div class="modal fade" id="addClue">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add / Edit Clues</h4>
      </div>
      <div class="modal-body">
        <?php include_once("AddEditClue.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addAnswer">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add / Edit Answers</h4>
      </div>
      <div class="modal-body">
        <?php include_once("AddEditAnswer.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="addHint">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add / Edit Hints</h4>
      </div>
      <div class="modal-body">
        <?php include_once("AddEditHint.php"); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>