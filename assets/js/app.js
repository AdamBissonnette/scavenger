function loadCytoscape(data)
{

    $('#cy').cytoscape({
      style: cytoscape.stylesheet()
        .selector('node')
      .css({
        'content': 'data(id)'
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