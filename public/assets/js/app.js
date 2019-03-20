let input = $('.celebrity-input');
let matchLeftInput = $('#match-left').find('input');
let matchRightInput = $('#match-right').find('input');
let flames = $('.flames');
let matchButton = $('#match-button');

console.log(matchButton);

// When edit celebrity input
input.change(function(e) {
  let query = $(this).val();
  let parentDiv = $(this).parent();
  let parentClass = parentDiv.attr('id');
  let currentMatchImage = parentDiv.find('.match-img');

  console.log(query);

  if (query) {
    fetch('/api/getImages/' + query).
        then(response => response.json()).
        then(data => {
          currentMatchImage.attr('src', data.data);
        }).
        catch(error => console.error(error));
  } else {
    currentMatchImage.attr('src', 'https://bulma.io/images/placeholders/128x128.png');
  }

});

// Add match button
input.on('input', function() {
  if (matchLeftInput.val() !== '' && matchRightInput.val() !== '') {
    matchButton.show();
    matchButton.attr('class', 'animated fadeIn delay-1s');
  } else {
    matchButton.hide();
  }
});