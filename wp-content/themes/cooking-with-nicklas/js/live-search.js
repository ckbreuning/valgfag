// Live Search Logik

var searchDelay = 300;
var minSearchChars = 2;

document.addEventListener('DOMContentLoaded', () => {

  var input = document.getElementById('recipe-search-input');
  var resultsList = document.getElementById('recipe-search-results');

  if (!input || !resultsList || typeof cookingSearch === 'undefined') {
    return;
  }

  var searchTimer = null;
  var requestCount = 0;

  var closeResults = () => {
    resultsList.innerHTML = '';
    resultsList.classList.remove('is-open');
  };

  var showMessage = (text) => {
    resultsList.innerHTML = '<li class="site-search__message">' + text + '</li>';
    resultsList.classList.add('is-open');
  };

  var showResults = (recipes) => {
    if (recipes.length === 0) {
      showMessage('No recipes found.');
      return;
    }

    resultsList.innerHTML = '';

    recipes.forEach((recipe) => {
      var item = document.createElement('li');
      var link = document.createElement('a');

      link.href = recipe.link;
      link.className = 'site-search__result-link';
      link.innerHTML = recipe.title.rendered;

      item.appendChild(link);
      resultsList.appendChild(item);
    });

    resultsList.classList.add('is-open');
  };

  var runSearch = (term) => {
    var thisRequest = ++requestCount;
    var url = cookingSearch.restUrl
      + '?search=' + encodeURIComponent(term)
      + '&per_page=8'
      + '&_fields=id,title,link';

    showMessage('Searching…');

    fetch(url)
      .then((response) => {
        return response.json();
      })
      .then((recipes) => {
        if (thisRequest !== requestCount) {
          return;
        }
        showResults(recipes);
      })
      .catch(() => {
        if (thisRequest === requestCount) {
          showMessage('Something went wrong. Please try again.');
        }
      });
  };

  input.addEventListener('input', () => {
    var term = input.value.trim();

    if (searchTimer) {
      clearTimeout(searchTimer);
    }

    if (term.length < minSearchChars) {
      closeResults();
      return;
    }

    searchTimer = setTimeout(() => {
      runSearch(term);
    }, searchDelay);
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('.site-search')) {
      closeResults();
    }
  });

  input.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeResults();
      input.blur();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 's' && event.key !== 'S') {
      return;
    }

    var active = document.activeElement;
    var isTyping = active && (
      active.tagName === 'INPUT'
      || active.tagName === 'TEXTAREA'
      || active.tagName === 'SELECT'
      || active.isContentEditable
    );

    if (isTyping) {
      return;
    }

    event.preventDefault();
    input.focus();
  });

});
