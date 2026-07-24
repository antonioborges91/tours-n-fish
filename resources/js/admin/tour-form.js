document.addEventListener('DOMContentLoaded', () => {
    const optionsContainer = document.getElementById('options-container');
    const optionTemplate = document.getElementById('option-template');
    const scheduleTemplate = document.getElementById('schedule-template');
    const galleryImageTemplate = document.getElementById('gallery-image-template');
    const addOptionButton = document.getElementById('add-option');
    const addImageButton = document.getElementById('add-image');
    const galleryContainer = document.getElementById('gallery-container');

    if (!optionsContainer || !optionTemplate || !addOptionButton) {
        return;
    }

    let optionIndex = optionsContainer.querySelectorAll('.option-card').length;

    const optionFieldName = (index, field) => {
        if (field === 'pt_name') {
            return `options[${index}][translations][pt][name]`;
        }

        if (field === 'en_name') {
            return `options[${index}][translations][en][name]`;
        }

        return `options[${index}][${field}]`;
    };

    const scheduleFieldName = (option, schedule, field) =>
        `options[${option}][schedules][${schedule}][${field}]`;

    function getOptionFields(card) {
        const fields = card.querySelectorAll('[data-name]');

        if (fields.length > 0) {
            return Array.from(fields).map((field) => ({
                element: field,
                name: field.dataset.name,
            }));
        }

        return Array.from(card.querySelectorAll(':scope > .grid input[name]')).map((field, index) => ({
            element: field,
            name: ['pt_name', 'en_name', 'duration_minutes', 'price'][index],
        }));
    }

    function getScheduleFields(row) {
        const fields = row.querySelectorAll('[data-field]');

        if (fields.length > 0) {
            return Array.from(fields).map((field) => ({
                element: field,
                name: field.dataset.field,
            }));
        }

        return Array.from(row.querySelectorAll('input[name]')).map((field, index) => ({
            element: field,
            name: ['start_time', 'end_time'][index],
        }));
    }

    function renumberSchedules(card, currentOptionIndex) {
        const schedulesContainer = card.querySelector('.option-schedules');

        if (!schedulesContainer) {
            return;
        }

        const rows = schedulesContainer.querySelectorAll('.schedule-row');

        rows.forEach((row, scheduleIndex) => {
            row.dataset.scheduleIndex = scheduleIndex;

            getScheduleFields(row).forEach((field) => {
                field.element.name = scheduleFieldName(
                    currentOptionIndex,
                    scheduleIndex,
                    field.name,
                );
            });

            prepareScheduleButton(row, card);
        });

        if (rows.length === 0 && !schedulesContainer.querySelector('.no-option-schedules')) {
            schedulesContainer.innerHTML = '<p class="text-gray-500 no-option-schedules">Ainda não existem horários.</p>';
        }
    }

    function renumberOptions() {
        const cards = optionsContainer.querySelectorAll('.option-card');

        cards.forEach((card, index) => {
            card.dataset.optionIndex = index;

            const title = card.querySelector('h3');
            if (title) {
                title.textContent = `Opção ${index + 1}`;
            }

            getOptionFields(card).forEach((field) => {
                field.element.name = optionFieldName(index, field.name);
            });

            renumberSchedules(card, index);
            prepareOptionButtons(card);
        });

        optionIndex = cards.length;

        const emptyState = optionsContainer.querySelector('#no-options');
        if (cards.length > 0 && emptyState) {
            emptyState.remove();
        }

        if (cards.length === 0 && !emptyState) {
            optionsContainer.insertAdjacentHTML(
                'beforeend',
                '<p id="no-options" class="text-gray-500">Ainda não existem opções.</p>',
            );
        }
    }

    function prepareScheduleButton(row, card) {
        const removeButton = row.querySelector('.remove-schedule');

        if (!removeButton || removeButton.dataset.initialized) {
            return;
        }

        removeButton.dataset.initialized = 'true';
        removeButton.addEventListener('click', () => {
            row.remove();
            renumberSchedules(card, Number(card.dataset.optionIndex));
        });
    }

    function addSchedule(card) {
        if (!scheduleTemplate) {
            return;
        }

        const schedulesContainer = card.querySelector('.option-schedules');

        if (!schedulesContainer) {
            return;
        }

        schedulesContainer.querySelector('.no-option-schedules')?.remove();

        const fragment = scheduleTemplate.content.cloneNode(true);
        const row = fragment.querySelector('.schedule-row');

        if (!row) {
            return;
        }

        schedulesContainer.appendChild(row);
        renumberSchedules(card, Number(card.dataset.optionIndex));
    }

    function prepareOptionButtons(card) {
        const removeButton = card.querySelector('.remove-option');
        const addScheduleButton = card.querySelector('.add-option-schedule');

        if (removeButton && !removeButton.dataset.initialized) {
            removeButton.dataset.initialized = 'true';
            removeButton.addEventListener('click', () => {
                card.remove();
                renumberOptions();
            });
        }

        if (addScheduleButton && !addScheduleButton.dataset.initialized) {
            addScheduleButton.dataset.initialized = 'true';
            addScheduleButton.addEventListener('click', () => addSchedule(card));
        }
    }

    function addOption() {
        optionsContainer.querySelector('#no-options')?.remove();

        const fragment = optionTemplate.content.cloneNode(true);
        const card = fragment.querySelector('.option-card');

        if (!card) {
            return;
        }

        card.dataset.optionIndex = optionIndex;
        optionsContainer.appendChild(card);
        renumberOptions();
    }

    function prepareGalleryRow(row) {
        const removeButton = row.querySelector('.remove-image');

        if (!removeButton || removeButton.dataset.initialized) {
            return;
        }

        removeButton.dataset.initialized = 'true';
        removeButton.addEventListener('click', () => {
            row.remove();

            if (!galleryContainer?.querySelector('.gallery-row')) {
                galleryContainer?.insertAdjacentHTML(
                    'beforeend',
                    '<p id="no-images" class="text-gray-500">Ainda não existem imagens.</p>',
                );
            }
        });
    }

    function addGalleryImage() {
        if (!galleryContainer || !galleryImageTemplate) {
            return;
        }

        galleryContainer.querySelector('#no-images')?.remove();

        const fragment = galleryImageTemplate.content.cloneNode(true);
        const row = fragment.querySelector('.gallery-row');

        if (!row) {
            return;
        }

        galleryContainer.appendChild(row);
        prepareGalleryRow(row);
    }

    addOptionButton.addEventListener('click', addOption);
    addImageButton?.addEventListener('click', addGalleryImage);

    optionsContainer.querySelectorAll('.option-card').forEach((card) => {
        prepareOptionButtons(card);
        card.querySelectorAll('.schedule-row').forEach((row) => prepareScheduleButton(row, card));
    });

    galleryContainer?.querySelectorAll('.gallery-row').forEach(prepareGalleryRow);
    renumberOptions();

    if (optionsContainer.querySelectorAll('.option-card').length === 0) {
        addOption();
    }
});
