let input = $('.celebrity-input');
let inputData = input.data('options');
let matchLeftInput = $('#match-left').find('input');
let matchRightInput = $('#match-right').find('input');
let matchButton = $('#match-button');
let flames = $('.flames');
let timer = null;

function addCelebrityImage(inputThis) {
  let query = inputThis.val();
  let parentDiv = inputThis.parent();
  let parentClass = parentDiv.attr('id');
  let currentMatchImage = parentDiv.find('.match-img');

  if (query) {
    fetch('/api/getImages/' + query).
        then(response => response.json()).
        then(data => {
          console.log(inputThis.data( "options" ));
          currentMatchImage.attr('src', data.data);
        }).
        catch(error => console.error(error));
  } else {
    currentMatchImage.attr('src', 'https://bulma.io/images/placeholders/128x128.png');
  }
}

function displayMatchButton() {
  if (matchLeftInput.val() !== '' && matchRightInput.val() !== '') {
    matchButton.show();
    matchButton.attr('class', 'animated fadeIn delay-1s');
  } else {
    matchButton.attr('class', 'animated fadeOut');
    matchButton.delay(1000).hide(0);
  }
}

input.keydown(function(){
  clearTimeout(timer);
  timer = setTimeout(doStuff, 1000, $(this))
});

function doStuff(inputThis) {
  addCelebrityImage(inputThis);
  displayMatchButton();
}