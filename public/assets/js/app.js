let input = $('.celebrity-input');
let inputData = input.data('options');
let matchLeftInput = $('#match-left').find('input');
let matchRightInput = $('#match-right').find('input');
let matchButton = $('#match-button');
let noMatchButton = $('#none-match-button');
let flames = $('#flames');
let breakMatch = $('#break-match');
let timer = null;
let nbrOcuurence = $('#occurence_number');

const APIKEY = "0f5ac6fc2aee41ba90a195c209dadef7";


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
    let currentWindow = window.location.origin;
    currentMatchImage.attr('src', currentWindow + '/img/man-copy.png');
  }
}

function displayMatchButton() {
  if (matchLeftInput.val() !== '' && matchRightInput.val() !== '') {
    getOccurence(matchLeftInput.val(), matchRightInput.val() )
  } else {
    hideElement(breakMatch);
    hideElement(noMatchButton);
    hideElement(flames);
    hideElement(matchButton);
  }
}

input.keydown(function(){
  clearTimeout(timer);
  timer = setTimeout(doStuff, 1000, $(this))
});

function getOccurence(firstQuery, secondQuery) {


  let url = 'https://api.ozae.com/gnw/uc/raw-search?q='+ firstQuery+'+'+secondQuery+'&date=20180101__20190101&key='+APIKEY;
  fetch(url)
      .then(response => response.json())
      .then(data => {
        if(data.articles_ids){
          hideElement(breakMatch);
          hideElement(noMatchButton);
          showElement(flames);
          showElement(matchButton);
          nbrOcuurence.show().html(data.articles_ids.length + ' article(s)');
          nbrOcuurence.attr('class', 'animated fadeIn delay-1s');
        } else {
          showElement(breakMatch);
          showElement(noMatchButton);
          hideElement(flames);
          hideElement(matchButton);
          nbrOcuurence.attr('class', 'animated fadeOut');
          nbrOcuurence.delay(1000).hide(0);
        }
      })
}

function showElement(element) {
    element.show();
    element.attr('class', 'animated fadeIn delay-1s');
}

function hideElement(element) {
  element.attr('class', 'animated fadeOut');
  element.delay(1000).hide(0);
}

function doStuff(inputThis) {
  addCelebrityImage(inputThis);
  displayMatchButton();
}


matchButton.on('click', function (e) {
    document.location.href = "http://localhost:8000/hot/match/"+matchLeftInput.val()+"/"+matchRightInput.val();
});

