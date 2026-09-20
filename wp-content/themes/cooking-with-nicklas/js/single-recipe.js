// Logik for den enkelte opskrifts-side

// Ventetid i millisekunder før vi fjerner "focus mode"
var closeDelay = 300;

// Vent med at køre koden, indtil hele hjemmesiden er indlæst
document.addEventListener('DOMContentLoaded', () => {

  // Logik til at folde ingredienslisten ud og ind 

  // Find knappen til at folde ud/ind, og selve kassen med ingredienser
  var ingredientsToggle = document.getElementById('ingredients-toggle');
  var ingredientsBlock = document.getElementById('recipe-ingredients');

  // Hvis begge dele findes på siden, sætter vi klik-logikken op
  if (ingredientsToggle && ingredientsBlock) {
    ingredientsToggle.addEventListener('click', () => {
      // Tilføj eller fjern klassen 'is-collapsed'
      ingredientsBlock.classList.toggle('is-collapsed');
    });
  }

  //  Logik til "focus mode" 

  // Find knappen til focus-mode og backdrop-elementet 
  var focusToggle = document.getElementById('focus-toggle');
  var focusBackdrop = document.getElementById('focus-backdrop');

  // Hvis knappen findes, går vi videre
  if (focusToggle) {
    // Find ikonet og teksten inde i focus-knappen
    var focusIcon = focusToggle.querySelector('i');
    var focusLabel = document.getElementById('focus-toggle-label');

    // En timer vi bruger til at styre animationen, når man lukker focus-mode
    var closeTimer = null;

    // En funktion der tænder (true) eller slukker (false) for focus-mode
    var setFocusMode = (isFocused) => {
      // Skift teksten og ikonet på knappen, alt efter om vi er i focus-mode eller ej
      focusLabel.textContent = isFocused ? 'Exit focus mode' : 'Focus mode';
      focusIcon.className = isFocused ? 'fa-solid fa-compress' : 'fa-solid fa-expand';

      if (isFocused) {
        // Hvis vi slår focus-mode til:
        document.body.classList.add('is-focused'); // Gør siden klar til focus-mode
        document.body.classList.add('is-focused-visible'); // Gør det synligt
      } else {
        // Hvis vi slår focus-mode fra:
        document.body.classList.remove('is-focused-visible'); // Start med at skjule det

        // Vent et lille øjeblik (closeDelay) på at animationen er færdig, før vi fjerner klassen helt
        closeTimer = window.setTimeout(() => {
          document.body.classList.remove('is-focused');
          closeTimer = null;
        }, closeDelay);
      }
    };

    // Lyt efter klik på knappen til focus-mode
    focusToggle.addEventListener('click', () => {
      // Find ud af, om vi allerede er i focus-mode
      var isOpen = document.body.classList.contains('is-focused-visible')
        || document.body.classList.contains('is-focused');

      // Skift til det modsatte af, hvad den er nu (er den åben, så luk. Er den lukket, så åbn)
      setFocusMode(!isOpen);
    });

    // Hvis baggrunden findes, vil vi gerne lukke focus-mode, når man klikker på den
    if (focusBackdrop) {
      focusBackdrop.addEventListener('click', () => {
        setFocusMode(false); // Luk focus-mode
      });
    }

    // Lyt efter tryk på tastaturet (uanset hvor på siden man er)
    document.addEventListener('keydown', (event) => {
      // Hvis man trykker på 'Escape' og vi er i focus-mode, så luk focus-mode
      if (event.key === 'Escape' && document.body.classList.contains('is-focused')) {
        setFocusMode(false);
      }
    });
  }

});