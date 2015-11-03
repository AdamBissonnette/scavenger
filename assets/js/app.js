function loadCytoscape(data)
{
    window.map = cytoscape({
      container: document.getElementById('cy'),
      boxSelectionEnabled: false,
      autounselectify: false,
      hideLabelsOnViewport: true,
      style: cytoscape.stylesheet()
        .selector('node')
      .css({
        'content': 'data(label)'
      })
        .selector('edge')
      .css({
        'target-arrow-shape': 'triangle',
        'width': 4,
        'line-color': '#ddd',
        'target-arrow-color': '#ddd'
      })
        .selector('.highlighted')
      .css({
        'background-color': '#61bffc',
        'line-color': '#61bffc',
        'target-arrow-color': '#61bffc',
        'transition-property': 'background-color, line-color, target-arrow-color',
        'transition-duration': '0.5s'
      }),
      
      elements: data,
      
      layout: {
        name: 'breadthfirst',
        directed: true,
        padding: 10
      },
      
      ready: function(){
        // ready 1
        for (var i = 0; i < data["nodes"].length; i++)
        {
          var item = data["nodes"][i];
          var id = item["data"]["id"];

          map.$('#' +id).addClass(id);
          addQTip(id, item["data"]["label"], "c");
        }

        for (var i = 0; i < data["edges"].length; i++)
        {
          var itemdata = data["edges"][i]["data"];

          if (itemdata["warning"])
          {
            map.$('#' +itemdata["id"]).style("line-color", "red").style("target-arrow-color", "red");
            //console.log(map.$('#' +itemdata["id"]).style());
          }
          map.$('#' +itemdata["id"]).addClass("a" + itemdata["item"]);

          addQTip(itemdata["id"], itemdata["id"], "a");
        }
      }
    });

}

function addQTip(id, label, type)
{
  var target = "";
  var linkCtrl = "";
  var element = map.$('#' + id);

  var title = '<div class="item-title">' + label + '</div>';
  var delCtrl = '<button type="button" class="btn btn-danger" onclick="delItem(\''+ type+'\', %s)">delete</button></div>';

  switch (type)
  {
    case 'c':
      target = "#addClue";
      linkCtrl = '<div class="form-group"><select id="linkTo%s" class="linkTo form-control"><option value="-1">Select Clue</option></select><button type="button" class="form-control btn btn-primary" onclick="linkItem(%s)">Connect</button></div>';
    break;
    case 'a':
      target = "#addAnswer";
      delCtrl = '<button type="button" class="btn btn-danger" onclick="delLink(\''+ type+'\', %s)">delete</button></div>';
      linkCtrl = '<div class="form-group"><select id="linkTo%s" class="linkTo form-control"><option value="-1">Select Clue</option></select><button type="button" class="form-control btn btn-primary" onclick="linkAnswer(%s)">Connect</button></div>';
    break;
    case 'h':
      target = "#addHint";
    break;
  }

  var editCtrl = '<div class="form-group"><button type="button" class="btn btn-success" onclick="editItem(\''+ type+'\', %s)" data-toggle="modal" data-target="' + target +'">edit</button> ';
  var controls = (title + editCtrl + delCtrl + linkCtrl).replace(/%s/g, element.data().item);

  element.qtip({
      content: controls,
      events: {
        render: function (event, api) {
          var select = $('.linkTo');
          select.empty();
          var options = $("#inputNextClue > option").clone();
          select.append(options);
        }
      },
      position: {
        my: 'top center',
        at: 'bottom center'
      },
      style: {
        classes: 'qtip-bootstrap',
        tip: {
          width: 16,
          height: 8
        }
      }
    });
}

function loadMap()
{
  var data = {fn: 'getMap', storyid : $('#navStory').val()};
    $.ajax({url: "callbacks.php",
        data: JSON.stringify(data),
        processData: false,
        dataType: "json",
        method: "POST",
        success: function(a) {loadCytoscape(a);},
        error: function (jqXHR, textStatus) {"Request failed: " + textStatus}

    });
}

function editItem(itemType, itemId)
{
  $('#' + itemType + itemId + 'edit').click();

  try {
    map.$('.' + itemType + itemId)[0].qtip('api').hide();
  } catch(e) {console.log(e);}
}

function linkItem(itemId)
{
  var linkTo = $('#linkTo' + itemId).val();
  // console.log(linkTo + " from " + itemId);

  var data = {fn: "linkclues", fromid: itemId, toid: linkTo};
    $.ajax({url: "callbacks.php",
        data: JSON.stringify(data),
        processData: false,
        dataType: "json",
        method: "POST",
        success: function(data) {createLink(data, itemId, linkTo);},
        error: function (jqXHR, textStatus) {"Request failed: " + textStatus}

    });
}

function linkAnswer(itemId)
{
  var linkFrom = $('#linkTo' + itemId).val();
  var selectedData = map.$(':selected').data();

  var data = {fn: "assignAnswer", clueid: linkFrom, answerid: selectedData.item, checked: true};

  $.ajax({url: "callbacks.php",
      data: JSON.stringify(data),
      processData: false,
      dataType: "json",
      method: "POST",
      success: function() {createLink({id: selectedData.item}, linkFrom, selectedData.target.replace("c", ""));},
      error: function (jqXHR, textStatus) {"Request failed: " + textStatus}

  });
}

function createLink(data, fromid, toid)
{
  //add new element to the map
  var answerid = data.id;
  var itemLabel = "a" + answerid + '-c' + fromid + '-c' + toid;
  map.add({group: "edges", data: {id: itemLabel, item: answerid, weight: 5, source: "c" + fromid, target: "c" + toid, warning: true}})
    .style("line-color", "red")
    .style("target-arrow-color", "red");

  addQTip(itemLabel, itemLabel, "a");
}

function delItem(itemType, itemId)
{
  var r = confirm("Are you sure you want to delete this item?");
  if (r == true) {
    var ident = itemType + itemId;
    //console.log(ident);
    $('#' + ident + 'del').click();
    try {map.$('.' + ident).qtip('api').hide();} catch(e) {console.log(e);}
    map.$(':selected').remove();
  }
}

function delLink(itemType, itemId)
{
  var r = confirm("Are you sure you want to delete this item?");
  if (r == true) {
    var selectedData = map.$(':selected').data();
    var sourceID = selectedData.source.replace("c", "");
    var data = {fn: "assignAnswer", clueid: sourceID, answerid: selectedData.item, checked: false};

    $.ajax({url: "callbacks.php",
        data: JSON.stringify(data),
        processData: false,
        dataType: "json",
        method: "POST",
        success: function(data) {},
        error: function (jqXHR, textStatus) {"Request failed: " + textStatus}

    });

    try {map.$(':selected').qtip('api').hide();} catch(e) {console.log(e);}
    map.$(':selected').remove();
  }
}