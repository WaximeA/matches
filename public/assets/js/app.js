let input = $('.celebrity-input');
let inputData = input.data('options');
let matchLeftInput = $('#match-left').find('input');
let matchRightInput = $('#match-right').find('input');
let matchButton = $('#match-button');
let noMatchButton = $('#none-match-button');
let flames = $('#flames');
let breakMatch = $('#break-match');
let loader = $('#main-loader');
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
    loader.show();
    getOccurence(matchLeftInput.val(), matchRightInput.val() )
  } else {
    loader.hide();
    hideElement(loader);
    hideElement(breakMatch);
    hideElement(noMatchButton);
    hideElement(flames);
    hideElement(matchButton);
    hideElement(nbrOcuurence);
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
          nbrOcuurence.attr('class', 'animated fadeIn');
        } else {
          showElement(breakMatch);
          showElement(noMatchButton);
          hideElement(flames);
          hideElement(matchButton);
          hideElement(nbrOcuurence);
        }
      })
}

function showElement(element) {
    element.show();
    element.attr('class', 'animated fadeIn');
}

function hideElement(element) {
  element.attr('class', 'animated fadeOut');
  element.hide();
}

function doStuff(inputThis) {
  addCelebrityImage(inputThis);
  displayMatchButton();
}


matchButton.on('click', function (e) {
    document.location.href = "http://localhost:8000/hot/match/"+matchLeftInput.val()+"/"+matchRightInput.val();
});

