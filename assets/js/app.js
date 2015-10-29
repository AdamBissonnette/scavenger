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
      .css({
        'target-arrow-shape': 'triangle',
        'width': 4,
        'line-color': '#ddd',
        'target-arrow-color': '#ddd'
      })
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

        }
      }
    });

}

{
  var element = map.$('#' + id);
  var editClue = '<button type="button" class="btn btn-success" onclick="editItem(\'c\', %s)" data-toggle="modal" data-target="#addClue">edit</button> ';
  var linkClue = '';//'<button type="button" class="btn btn-primary" onclick="linkItem(\'c\', %s)">link</button> ';
  var delClue = '<button type="button" class="btn btn-danger" onclick="delItem(\'c\', %s)">delete</button>';


  element.qtip({
      content: controls,
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
}

function linkItem(itemType, itemId)
{
  $('#' + itemType + itemId + 'link').click(); 
}

function delItem(itemType, itemId)
{
  var r = confirm("Are you sure you want to delete this item?");
  if (r == true) {
    var ident = '#' + itemType + itemId;
    $(ident + 'del').click();
  }
}