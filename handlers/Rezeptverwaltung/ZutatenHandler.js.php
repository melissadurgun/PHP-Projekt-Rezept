let ingredientIndex = 1; // Initialize ingredient index globally

function zutatHinzufügen() {
const zutatenContainer = document.getElementById('zutaten');

// Create a new div to hold the ingredient fields and delete button
const zutatenRow = document.createElement('div');
zutatenRow.classList.add('zutaten-row');
zutatenRow.setAttribute('id', `zutaten-row-${ingredientIndex}`);

// Generate the fields for the new ingredient
const nameField = `<input type="text" name="zutaten[${ingredientIndex}][name]" placeholder="Zutat" required>`;
const mengeField = `<input type="number" name="zutaten[${ingredientIndex}][menge]" placeholder="Menge" step="0.1"
    required>`;
const einheitField = `<select name="zutaten[${ingredientIndex}][einheit]">
    <option value="g">g</option>
    <option value="ml">ml</option>
    <option value="Stück">Stück</option>
    <option value="TL">TL</option>
    <option value="EL">EL</option>
    <option value="L">L</option>
    <option value="kg">kg</option>
</select>`;

// Create the delete button for the ingredient
const deleteButton = document.createElement('button');
deleteButton.type = 'button';
deleteButton.innerHTML = '<i class="fa fa-trash-o"></i> Löschen';
deleteButton.setAttribute('id', `delete-zutat`);
deleteButton.setAttribute('class', 'deleteButton');
deleteButton.onclick = function () {
zutatenRow.remove();
};

// Append fields and the delete button to the ingredient container
zutatenRow.insertAdjacentHTML('beforeend', nameField + mengeField + einheitField);
zutatenRow.appendChild(deleteButton);

// Append the ingredient container to the main zutaten div
zutatenContainer.appendChild(zutatenRow);

// Increment the index for the next ingredient
ingredientIndex++;
}