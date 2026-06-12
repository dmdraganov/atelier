document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

const priceForm = document.querySelector('[data-price-form]');

if (priceForm) {
    const formatter = new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        maximumFractionDigits: 0,
    });

    const calculate = () => {
        const model = priceForm.querySelector('[data-model]');
        const material = priceForm.querySelector('[data-material]');
        const quantity = priceForm.querySelector('[data-quantity]');
        const complexity = priceForm.querySelector('[data-complexity]');
        const urgency = priceForm.querySelector('[data-urgency]');
        const output = priceForm.querySelector('[data-estimate]');

        const base = Number(model.selectedOptions[0]?.dataset.price || 0);
        const materialPrice = Number(material.selectedOptions[0]?.dataset.price || 0);
        const count = Math.max(1, Number(quantity.value || 1));
        const complexityMultiplier = Number(complexity.selectedOptions[0]?.dataset.multiplier || 1);
        const urgencyMultiplier = Number(urgency.selectedOptions[0]?.dataset.multiplier || 1);

        output.textContent = formatter.format((base + materialPrice) * complexityMultiplier * urgencyMultiplier * count);
    };

    priceForm.querySelectorAll('select, input').forEach((field) => {
        field.addEventListener('change', calculate);
        field.addEventListener('input', calculate);
    });

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
