document.addEventListener('DOMContentLoaded', () => {

    const addButton = document.getElementById('add-schedule');
    const container = document.getElementById('schedule-container');
    const emptyMessage = document.getElementById('no-schedules');

    addButton.addEventListener('click', () => {

        if (emptyMessage) {
            emptyMessage.remove();
        }

        const row = document.createElement('div');

        row.className = 'grid grid-cols-12 gap-4 items-end mb-4';

        row.innerHTML = `
            <div class="col-span-5">
                <label class="form-label">
                    Hora Início
                </label>

                <input
                    type="time"
                    name="schedule_start[]"
                    class="form-input">
            </div>

            <div class="col-span-5">
                <label class="form-label">
                    Hora Fim
                </label>

                <input
                    type="time"
                    name="schedule_end[]"
                    class="form-input">
            </div>

            <div class="col-span-2">

                <button
                    type="button"
                    class="admin-btn-danger remove-schedule">

                    Remover

                </button>

            </div>
        `;

        container.appendChild(row);

    });

    container.addEventListener('click', (event) => {

        if (!event.target.classList.contains('remove-schedule')) {
            return;
        }

        event.target.closest('.grid').remove();

        if (container.children.length === 0) {

            container.innerHTML = `
                <p id="no-schedules" class="text-gray-500">
                    Ainda não existem horários.
                </p>
            `;

        }

    });

    /* -------------------------------------------------------------------------- */
/* Galeria */
/* -------------------------------------------------------------------------- */

const addImageButton = document.getElementById('add-image');
const galleryContainer = document.getElementById('gallery-container');

addImageButton.addEventListener('click', () => {

    const empty = document.getElementById('no-images');

    if (empty) {
        empty.remove();
    }

    const totalImages = galleryContainer.querySelectorAll('.gallery-row').length;

    if (totalImages >= 5) {

        alert('Pode adicionar no máximo 5 imagens.');

        return;
    }

    const row = document.createElement('div');

    row.className = 'gallery-row flex items-end gap-4 mb-4';

    row.innerHTML = `
        <div class="flex-1">

            <label class="form-label">
                Imagem
            </label>

            <input
                type="file"
                name="gallery_images[]"
                class="form-input"
                accept="image/*">

        </div>

        <button
            type="button"
            class="admin-btn-danger remove-image">

            Remover

        </button>
    `;

    galleryContainer.appendChild(row);

});

galleryContainer.addEventListener('click', (event) => {

    if (!event.target.classList.contains('remove-image')) {
        return;
    }

    event.target.closest('.gallery-row').remove();

    if (galleryContainer.children.length === 0) {

        galleryContainer.innerHTML = `
            <p id="no-images" class="text-gray-500">
                Ainda não existem imagens.
            </p>
        `;

    }

});

});