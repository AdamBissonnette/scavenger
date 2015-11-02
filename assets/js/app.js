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

          addQTip(id, item["data"]["label"], "c");
        }

        for (var i = 0; i < data["edges"].length; i++)
        {
          var item = data["edges"][i];

          if (item["data"]["warning"])
          {
            map.$('#' +item["data"]["id"]).style("line-color", "red").style("target-arrow-color", "red");
            console.log(map.$('#' +item["data"]["id"]).style());
          }

          addQTip(item["data"]["id"], item["data"]["id"], "a");
        }
      }
    });

}

function addQTip(id, label, type)
{
  var target = "";
  var linkCtrl = "";
  switch (type)
  {
    case 'c':
      target = "#addClue";
      linkCtrl = '<div class="form-group"><select id="linkTo%s" class="linkTo form-control"><option value="-1">Select Clue</option></select><button type="button" class="form-control btn btn-primary" onclick="linkItem(%s)">Connect</button></div>';
    break;
    case 'a':
      target = "#addAnswer";
    break;
    case 'h':
      target = "#addHint";
    break;
  }

  var element = map.$('#' + id);
  var title = '<div class="item-title">' + label + '</div>';
  var editCtrl = '<div class="form-group"><button type="button" class="btn btn-success" onclick="editItem(\''+ type+'\', %s)" data-toggle="modal" data-target="' + target +'">edit</button> ';
  var delCtrl = '<button type="button" class="btn btn-danger" onclick="delItem(\''+ type+'\', %s)">delete</button></div>';

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
    map.$('#' + itemType + itemId).qtip('api').hide();
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

function createLink(data, fromid, toid)
{
  //add new element to the map
  var itemLabel = "a" + data.id + '-c' + fromid + '-c' + toid;
  map.add({group: "edges", data: {id: itemLabel, item: data.id, weight: 5, source: "c" + fromid, target: "c" + toid, warning: true}})
    .style("line-color", "red")
    .style("target-arrow-color", "red");

  addQTip(itemLabel, itemLabel, "a");
}

function delItem(itemType, itemId)
{
  var r = confirm("Are you sure you want to delete this item?");
  if (r == true) {
    var ident = '#' + itemType + itemId;
    console.log(ident);
    $(ident + 'del').click();
    map.$(':selected').remove();
    try {map.$(ident).qtip('api').hide();} catch(e) {console.log(e);}
  }
}