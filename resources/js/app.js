document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

const menuToggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

if (menuToggle && menu) {
    const setMenuOpen = (open) => {
        menu.classList.toggle('is-open', open);
        document.body.classList.toggle('is-menu-open', open);
        menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    menuToggle.addEventListener('click', () => {
        setMenuOpen(menuToggle.getAttribute('aria-expanded') !== 'true');
    });

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setMenuOpen(false);
        }
    });
}

document.querySelectorAll('input[type="tel"][name="phone"]').forEach((input) => {
    const formatPhone = () => {
        let digits = input.value.replace(/\D/g, '');

        if (digits.startsWith('8')) {
            digits = `7${digits.slice(1)}`;
        }

        if (digits && !digits.startsWith('7')) {
            digits = `7${digits}`;
        }

        digits = digits.slice(0, 11);

        const parts = [
            '+7',
            digits.slice(1, 4),
            digits.slice(4, 7),
            digits.slice(7, 9),
            digits.slice(9, 11),
        ];

        let formatted = parts[0];

        if (parts[1]) {
            formatted += ` ${parts[1]}`;
        }

        if (parts[2]) {
            formatted += ` ${parts[2]}`;
        }

        if (parts[3]) {
            formatted += `-${parts[3]}`;
        }

        if (parts[4]) {
            formatted += `-${parts[4]}`;
        }

        input.value = digits ? formatted : '';
    };

    input.addEventListener('input', formatPhone);
    input.addEventListener('blur', formatPhone);
    formatPhone();
});

const priceForm = document.querySelector('[data-price-form]');

if (priceForm) {
    const formatter = new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        maximumFractionDigits: 0,
    });

    const model = priceForm.querySelector('[data-model]');
    const service = priceForm.querySelector('[data-service]');
    const material = priceForm.querySelector('[data-material]');
    const quantity = priceForm.querySelector('[data-quantity]');
    const complexity = priceForm.querySelector('[data-complexity]');
    const urgency = priceForm.querySelector('[data-urgency]');
    const output = priceForm.querySelector('[data-estimate]');

    const toggleField = (selector, enabled) => {
        const field = priceForm.querySelector(selector);

        if (!field) {
            return;
        }

        field.classList.toggle('hidden', !enabled);
        field.querySelectorAll('input, select, textarea').forEach((input) => {
            input.disabled = !enabled;
        });
    };

    const selectedService = () => service.selectedOptions[0];

    const syncServiceFields = () => {
        const option = selectedService();
        const requiresModel = option?.dataset.requiresModel === '1';
        const requiresMaterial = option?.dataset.requiresMaterial === '1';
        const requiresMeasurements = option?.dataset.requiresMeasurements === '1';
        const appliesComplexity = option?.dataset.appliesComplexity === '1';
        const appliesUrgency = option?.dataset.appliesUrgency === '1';
        const appliesQuantity = option?.dataset.appliesQuantity === '1';
        const allowedModelIds = (option?.dataset.modelIds || '').split(',').filter(Boolean);

        toggleField('[data-model-field]', requiresModel);
        toggleField('[data-material-field]', requiresMaterial);
        toggleField('[data-measurements-field]', requiresMeasurements);
        toggleField('[data-complexity-field]', appliesComplexity);
        toggleField('[data-urgency-field]', appliesUrgency);
        toggleField('[data-quantity-field]', appliesQuantity);

        priceForm.querySelectorAll('[data-measurement-group]').forEach((group) => {
            const enabled = requiresMeasurements && group.dataset.measurementGroup === service.value;

            group.classList.toggle('hidden', !enabled);
            group.querySelectorAll('input').forEach((input) => {
                input.disabled = !enabled;
            });
        });

        if (requiresModel && allowedModelIds.length > 0) {
            model.querySelectorAll('option').forEach((modelOption) => {
                modelOption.hidden = !allowedModelIds.includes(modelOption.value);
                modelOption.disabled = !allowedModelIds.includes(modelOption.value);
            });

            if (!allowedModelIds.includes(model.value)) {
                model.value = allowedModelIds[0];
            }
        } else {
            model.querySelectorAll('option').forEach((modelOption) => {
                modelOption.hidden = false;
                modelOption.disabled = false;
            });
        }
    };

    const calculate = () => {
        const option = selectedService();
        const mode = option?.dataset.mode || 'model_based';
        const serviceBasePrice = Number(option?.dataset.basePrice || 0);
        const modelFactor = Number(option?.dataset.modelFactor || 0);
        const appliesComplexity = option?.dataset.appliesComplexity === '1';
        const appliesUrgency = option?.dataset.appliesUrgency === '1';
        const appliesQuantity = option?.dataset.appliesQuantity === '1';

        const modelPrice = Number(model.selectedOptions[0]?.dataset.price || 0) * modelFactor;
        const materialPrice = Number(material.selectedOptions[0]?.dataset.price || 0);
        const count = appliesQuantity ? Math.max(1, Number(quantity.value || 1)) : 1;
        const complexityMultiplier = appliesComplexity ? Number(complexity.selectedOptions[0]?.dataset.multiplier || 1) : 1;
        const urgencyMultiplier = appliesUrgency ? Number(urgency.selectedOptions[0]?.dataset.multiplier || 1) : 1;

        const basePrice = {
            model_based: serviceBasePrice + modelPrice + materialPrice,
            alteration: serviceBasePrice + modelPrice,
            fixed: serviceBasePrice,
        }[mode] || serviceBasePrice;

        output.textContent = formatter.format(basePrice * complexityMultiplier * urgencyMultiplier * count);
    };

    priceForm.querySelectorAll('select, input').forEach((field) => {
        field.addEventListener('change', () => {
            syncServiceFields();
            calculate();
        });
        field.addEventListener('input', calculate);
    });

    syncServiceFields();
    calculate();
}

const previewInput = document.querySelector('[data-preview-input]');
const previewList = document.querySelector('[data-preview-list]');

if (previewInput && previewList) {
    previewInput.addEventListener('change', () => {
        previewList.innerHTML = '';

        Array.from(previewInput.files || []).forEach((file) => {
            const item = document.createElement('span');
            item.textContent = file.name;
            previewList.appendChild(item);
        });
    });
}
