function setDraggable() {
  $('#products .card').draggable({
    cancel: 'a.ui-icon',
    revert: 'invalid',
    cursor: 'move',
    stack: '.card',
    containment: 'window'
  });
  
  $('#cart').droppable({
    accept: '#products div>.card',
    classes: {
    'ui-droppable-active': 'ui-state-highlight'
    }, 
    drop: function(event, ui) {
      $('#instructions').addClass('d-none')
      ui.draggable.unwrap().detach().appendTo($(this)).removeAttr('style').addClass("w-75 align-self-start p-0");      
    
      if ($('#cart .card').length >=2) {
        $(this).droppable('disable');
      }
    }
  });
  
  $('#products').droppable({
    accept: '#cart .card',
    classes: {
    'ui-droppable-active': 'ui-state-highlight'
    },
    drop: function(event, ui) {
      if ($('#cart .card').length < 2) {
        $('#cart').droppable('enable');
      }
      $('#instructions').removeClass('d-none')
      ui.draggable.detach().removeAttr('style').removeClass("w-75 align-self-start p-0").appendTo($(this)).wrap("<div class='col-sm-3'></div>");
    }
  });
};