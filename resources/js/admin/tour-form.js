document.addEventListener('DOMContentLoaded', () => {

    const optionsContainer = document.getElementById('options-container');
    const optionTemplate = document.getElementById('option-template');
    const scheduleTemplate = document.getElementById('schedule-template');
    const addOptionButton = document.getElementById('add-option');
    const noOptions = document.getElementById('no-options');

    if (
        !optionsContainer ||
        !optionTemplate ||
        !scheduleTemplate ||
        !addOptionButton
    ) {
        return;
    }

    let optionIndex = 0;

    addOptionButton.addEventListener('click', () => {
        addOption();
    });

    function addOption() {

        noOptions?.remove();

        const fragment = optionTemplate.content.cloneNode(true);

        const card = fragment.querySelector('.option-card');

        card.dataset.optionIndex = optionIndex;

        const title = card.querySelector('h3');

        title.textContent = `Opção ${optionIndex + 1}`;

        prepareOptionFields(card, optionIndex);

        prepareOptionButtons(card);

        optionsContainer.appendChild(card);

        optionIndex++;

        refreshOptionTitles();

    }

    function prepareOptionFields(card, index) {

        card.querySelectorAll('[data-field]').forEach(field => {

            const fieldName = field.dataset.field;

            switch (fieldName) {

                case 'pt_name':

                    field.name =
                        `options[${index}][translations][pt][name]`;

                    break;

                case 'en_name':

                    field.name =
                        `options[${index}][translations][en][name]`;

                    break;

                default:

                    field.name =
                        `options[${index}][${fieldName}]`;

            }

        });

    }

    function prepareOptionButtons(card) {

        const removeButton = card.querySelector('.remove-option');

        removeButton.addEventListener('click', () => {

            card.remove();

            refreshOptionTitles();

            if (
                optionsContainer.querySelectorAll('.option-card').length === 0
            ) {

                optionsContainer.innerHTML = `
                    <div
                        id="no-options"
                        class="rounded-lg border border-dashed border-gray-300 p-8 text-center text-gray-500">

                        Ainda não existem opções.

                    </div>
                `;

            }

        });

        const addScheduleButton =
            card.querySelector('.add-schedule');

        addScheduleButton.addEventListener('click', () => {

            addSchedule(card);

        });

    }
        function addSchedule(card) {

        const optionIdx = card.dataset.optionIndex;

        const scheduleList =
            card.querySelector('.option-schedule-list');

        const emptyMessage =
            scheduleList.querySelector('.no-option-schedules');

        if (emptyMessage) {
            emptyMessage.remove();
        }

        const scheduleIndex =
            scheduleList.querySelectorAll('.schedule-row').length;

        const fragment =
            scheduleTemplate.content.cloneNode(true);

        const row =
            fragment.querySelector('.schedule-row');

        row.dataset.scheduleIndex = scheduleIndex;

        row.querySelectorAll('[data-field]').forEach(field => {

            const fieldName = field.dataset.field;

            field.name =
                `options[${optionIdx}][schedules][${scheduleIndex}][${fieldName}]`;

        });

        const removeButton =
            row.querySelector('.remove-schedule');

        removeButton.addEventListener('click', () => {

            row.remove();

            refreshSchedules(card);

        });

        scheduleList.appendChild(row);

    }

    function refreshSchedules(card) {

        const optionIdx = card.dataset.optionIndex;

        const scheduleList =
            card.querySelector('.option-schedule-list');

        const rows =
            scheduleList.querySelectorAll('.schedule-row');

        rows.forEach((row, scheduleIndex) => {

            row.dataset.scheduleIndex = scheduleIndex;

            row.querySelectorAll('[data-field]').forEach(field => {

                const fieldName = field.dataset.field;

                field.name =
                    `options[${optionIdx}][schedules][${scheduleIndex}][${fieldName}]`;

            });

        });

        if (rows.length === 0) {

            scheduleList.innerHTML = `
                <div class="no-option-schedules text-gray-500">

                    Ainda não existem horários.

                </div>
            `;

        }

    }

    function refreshOptionTitles() {

        const cards =
            optionsContainer.querySelectorAll('.option-card');

        cards.forEach((card, optionIdx) => {

            card.dataset.optionIndex = optionIdx;

            card.querySelector('h3').textContent =
                `Opção ${optionIdx + 1}`;

            card.querySelectorAll('[data-field]').forEach(field => {

                const fieldName = field.dataset.field;

                switch (fieldName) {

                    case 'pt_name':

                        field.name =
                            `options[${optionIdx}][translations][pt][name]`;

                        break;

                    case 'en_name':

                        field.name =
                            `options[${optionIdx}][translations][en][name]`;

                        break;

                    case 'start_time':
                    case 'end_time':
                        break;

                    default:

                        field.name =
                            `options[${optionIdx}][${fieldName}]`;

                }

            });

            refreshSchedules(card);

        });

    }
        // Cria automaticamente a primeira opção
    addOption();

});