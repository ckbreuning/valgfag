// Vi laver en 'Class', der indeholder alt om vores søgefunktion
class Search {

  // constructor() kører automatisk, når vi starter vores søgefunktion
  constructor() {
    // Find søgefeltet og resultatlisten på siden
    this.searchField = document.getElementById('recipe-search-input');
    this.resultsList = document.getElementById('recipe-search-results');

    // Hvis noget mangler, eller indstillingerne ikke er der, så stopper vi her
    if (!this.searchField || !this.resultsList || typeof cookingSearch === 'undefined') {
      return;
    }

    // Gør klar til at lytte efter brugerens handlinger
    this.events();

    // Variabler til at holde styr på tilstanden (om listen er åben, hvad der sidst blev søgt på osv.)
    this.isResultsVisible = false;
    this.previousValue = '';
    this.typingTimer = null;
    this.requestCount = 0; // Holder styr på, hvilken søgning vi er i gang med
  }

  // Sætter vores EventListener op, så siden reagerer, når brugeren gør noget
  events() {
    // Lyt efter når brugeren slipper en tast i søgefeltet (keyup)
    this.searchField.addEventListener('keyup', this.typingLogic.bind(this));

    // Lyt efter tryk på tastaturet uanset hvor man er på siden
    document.addEventListener('keydown', this.keyPressDispatcher.bind(this));

    // Lyt efter museklik for at kunne lukke søgningen, når man klikker væk
    document.addEventListener('click', this.closeOnOutsideClick.bind(this));
  }

  // Bestemmer hvad der skal ske, mens brugeren skriver i søgefeltet
  typingLogic() {
    // Tjek om teksten faktisk har ændret sig
    if (this.searchField.value !== this.previousValue) {
      // Stop den forrige timer, da brugeren stadig skriver
      clearTimeout(this.typingTimer);

      // Hent teksten og fjern mellemrum i starten og slutningen
      var term = this.searchField.value.trim();

      // Hvis der er skrevet 2 eller flere bogstaver, så går vi videre med at søge. Ellers lukker vi resultatlisten.
      if (term.length >= 2) {
        this.showMessage('Searching...');
        // Start en timer på 300 millisekunder, før vi henter resultaterne
        this.typingTimer = setTimeout(this.getResults.bind(this), 300);
      } else {
        // Hvis der er for få bogstaver, lukker vi resultatlisten
        this.closeResults();
      }
    }

    // Husk hvad der stod i feltet, til næste gang vi tjekker
    this.previousValue = this.searchField.value;
  }

  // Henter selve resultaterne fra serveren
  getResults() {
    var term = this.searchField.value.trim();
    var thisRequest = ++this.requestCount; // For hver søgning vi laver, gemmer vi et nummer, så vi kan tjekke om svaret hører til den nyeste søgning

    // Bed serveren om at finde opskrifter, der matcher teksten
    fetch(cookingSearch.root_url + '/wp-json/cooking/v1/search?term=' + encodeURIComponent(term))
      .then((response) => response.json()) // Lav svaret om til JSON
      .then((recipes) => {
        // Hvis dette svar hører til en gammel søgning, så glem det og stop
        if (thisRequest !== this.requestCount) {
          return;
        }
        // Hvis det er det nyeste svar, så vis opskrifterne
        this.showResults(recipes);
      })
      .catch(() => {
        // Hvis der skete en fejl
        if (thisRequest === this.requestCount) {
          this.showMessage('Something went wrong. Please try again.');
        }
      });
  }

  // Viser de fundne opskrifter som en liste på skærmen
  showResults(recipes) {
    // Hvis der ikke er nogen opskrifter, viser vi en besked
    if (!recipes.length) {
      this.showMessage('No recipes found.');
      return;
    }

    // Byg HTML'en til listen ved at sætte et <li> ind for hver opskrift
    this.resultsList.innerHTML = recipes.map((recipe) => `
      <li><a class="site-search__result-link" href="${recipe.permalink}">${recipe.title}</a></li>
    `).join('');

    // Gør resultatlisten synlig og husk at den er åben
    this.resultsList.classList.add('is-open');
    this.isResultsVisible = true;
  }

  // Viser en simpel tekstbesked i resultatlisten
  showMessage(text) {
    this.resultsList.innerHTML = `<li class="site-search__message">${text}</li>`;
    this.resultsList.classList.add('is-open');
    this.isResultsVisible = true;
  }

  // Lukker og tømmer resultatlisten
  closeResults() {
    this.resultsList.innerHTML = ''; // Tøm listen
    this.resultsList.classList.remove('is-open'); // Skjul listen
    this.isResultsVisible = false; // Husk at listen nu er lukket
  }

  // Lukker resultatlisten, hvis man klikker med musen et sted udenfor søgeområdet
  closeOnOutsideClick(event) {
    if (this.isResultsVisible && !event.target.closest('.site-search')) {
      this.closeResults();
    }
  }

  // Håndterer bestemte tryk som 's' og 'Escape'.
  keyPressDispatcher(event) {
    // Hvis man trykker på 's' eller 'S', og man ikke allerede er ved at skrive i et felt, så hopper vi direkte til søgefeltet
    if ((event.key === 's' || event.key === 'S') && !this.isTypingSomewhere()) {
      event.preventDefault(); // Gør så man ikke skriver 's' i feltet med det samme man trykker "s".
      this.searchField.focus(); // Hop direkte til søgefeltet
    }

    // Hvis listen er åben, og man trykker på 'Escape'
    if (event.key === 'Escape' && this.isResultsVisible) {
      this.closeResults(); // Luk listen
      this.searchField.blur(); // Fjern fokus fra søgefeltet
    }
  }

  // Tjekker om brugeren er i gang med at skrive i et tekstfelt
  isTypingSomewhere() {
    var active = document.activeElement; // Find det element der er aktivt lige nu

    return !!(active && (
      active.tagName === 'INPUT'
      || active.tagName === 'TEXTAREA'
      || active.tagName === 'SELECT'
      || active.isContentEditable
    ));
  }
}

// Vent med at starte koden, indtil hele siden er indlæst
document.addEventListener('DOMContentLoaded', function () {
  new Search(); // Start vores søge-skabelon 
});