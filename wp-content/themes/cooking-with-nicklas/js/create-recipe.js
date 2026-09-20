// Tilføj ingrediens og fremgangsmåde logik

document.addEventListener('DOMContentLoaded', () => {

  var addRow = (listId, rowHtml) => {
    var list = document.getElementById(listId);
    if (!list) {
      return;
    }

    var row = document.createElement('div');
    row.className = 'dynamic-list__row';
    row.innerHTML = rowHtml;
    list.appendChild(row);
  };

  var addIngredientButton = document.getElementById('add-ingredient');
  if (addIngredientButton) {
    addIngredientButton.addEventListener('click', () => {
      addRow(
        'ingredients-list',
        '<input type="text" name="ingredient[]" placeholder="e.g. 200g flour">' +
        '<button type="button" class="dynamic-list__remove">&times;</button>'
      );
    });
  }

  var addStepButton = document.getElementById('add-step');
  if (addStepButton) {
    addStepButton.addEventListener('click', () => {
      addRow(
        'steps-list',
        '<textarea name="step[]" rows="2" placeholder="Describe this step"></textarea>' +
        '<button type="button" class="dynamic-list__remove">&times;</button>'
      );
    });
  }

  document.querySelectorAll('.dynamic-list').forEach((list) => {
    list.addEventListener('click', (event) => {
      if (event.target.classList.contains('dynamic-list__remove')) {
        event.target.closest('.dynamic-list__row').remove();
      }
    });
  });

});
