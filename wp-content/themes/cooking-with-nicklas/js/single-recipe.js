// Single Recipes Logik 

var closeDelay = 300;

document.addEventListener('DOMContentLoaded', () => {

  // Ingrediens liste kollaps logik 

  var ingredientsToggle = document.getElementById('ingredients-toggle');
  var ingredientsBlock = document.getElementById('recipe-ingredients');

  if (ingredientsToggle && ingredientsBlock) {
    ingredientsToggle.addEventListener('click', () => {
      var isCollapsed = ingredientsBlock.classList.toggle('is-collapsed');
      ingredientsToggle.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');
      ingredientsToggle.title = isCollapsed ? 'Expand ingredients' : 'Collapse ingredients';
    });
  }

  // Focus mode Logik

  var focusToggle = document.getElementById('focus-toggle');
  var focusBackdrop = document.getElementById('focus-backdrop');

  if (focusToggle) {
    var focusIcon = focusToggle.querySelector('i');
    var focusLabel = document.getElementById('focus-toggle-label');
    var closeTimer = null;

    var setFocusMode = (isFocused) => {
      if (closeTimer) {
        clearTimeout(closeTimer);
        closeTimer = null;
      }

      focusLabel.textContent = isFocused ? 'Exit focus mode' : 'Focus mode';
      focusIcon.className = isFocused ? 'fa-solid fa-compress' : 'fa-solid fa-expand';

      if (isFocused) {
        document.body.classList.add('is-focused');

        requestAnimationFrame(() => {
          document.body.classList.add('is-focused-visible');
        });

      } else {
        document.body.classList.remove('is-focused-visible');

        closeTimer = window.setTimeout(() => {
          document.body.classList.remove('is-focused');
          closeTimer = null;
        }, closeDelay);
      }
    };

    focusToggle.addEventListener('click', () => {
      var isOpen = document.body.classList.contains('is-focused-visible')
        || document.body.classList.contains('is-focused');
      setFocusMode(!isOpen);
    });

    if (focusBackdrop) {
      focusBackdrop.addEventListener('click', () => {
        setFocusMode(false);
      });
    }

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && document.body.classList.contains('is-focused')) {
        setFocusMode(false);
      }
    });
  }

});
