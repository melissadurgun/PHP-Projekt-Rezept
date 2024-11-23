document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.RezeptHinzufügenForm').addEventListener('submit', function (event) {
                const missingFields = [];
                const requiredFields = [
                    { id: 'titel', name: 'Titel' },
                    { id: 'portionen', name: 'Portionen' },
                    { id: 'zubereitungsdauer', name: 'Zubereitungsdauer' },
                    { id: 'schwierigkeitsgrad', name: 'Schwierigkeitsgrad' },
                    { id: 'zubereitung', name: 'Zubereitung' },
                    { id: 'mahlzeitkategorie', name: 'Menüart' },
                    { id: 'ernaehrung', name: 'Ernährung' },
                    { id: 'kueche', name: 'Küche' },
                    { id: 'file', name: 'Bild' }
                ];

                requiredFields.forEach(field => {
                    const input = document.getElementById(field.id);
                    if (!input || input.value.trim() === '') {
                        missingFields.push(field.name);
                    }
                });

                const ingredientInputs = document.querySelectorAll('#zutaten input');
                ingredientInputs.forEach(input => {
                    if (input.value.trim() === '') {
                        missingFields.push('Zutat');
                    }
                });

                if (missingFields.length > 0) {
                    event.preventDefault();
                    alert(`Bitte füllen Sie die folgenden Felder aus: ${missingFields.join(', ')}`);
                }
            });
        });