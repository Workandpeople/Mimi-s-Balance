export default function initUploadInvoice() {
    const form = document.getElementById('upload-invoice-form');
    const fileInput = form.querySelector('input[name="invoice_file"]');
    const analyzeBtn = document.getElementById('analyze-btn');
    const validateBtn = document.getElementById('validate-btn');
    const categoriesTable = document.getElementById('categories-table-container');
    const categoriesBody = document.getElementById('categories-table-body');
    const noCategories = document.getElementById('no-categories');
    const dateInput = document.getElementById('invoice-date');

    let fileData = null;

    if (!form) return;

    fileInput.addEventListener('change', () => {
        fileData = fileInput.files[0] || null;
        analyzeBtn.disabled = !fileData;
        validateBtn.disabled = true;
        categoriesBody.innerHTML = '';
        categoriesTable.classList.add('d-none');
        noCategories.classList.remove('d-none');
        dateInput.value = '';
    });

    analyzeBtn.addEventListener('click', () => {
        if (!fileData) return;

        const formData = new FormData();
        formData.append('file', fileData);

        analyzeBtn.textContent = 'Analyse...';
        analyzeBtn.disabled = true;

        fetch('/api/analyze-invoice', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
            .then(res => res.json())
            .then(response => {
                const detected = response.items || [];
                categoriesBody.innerHTML = '';

                if (response.date) {
                    dateInput.value = response.date;
                }

                if (detected.length > 0) {
                    detected.forEach((item, index) => {
                        const label = item.category || '';
                        const amount = item.amount_ht ?? item.amount_tva ?? 0;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <input type="text" class="form-control category-input" name="category_${index}" value="${label}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control amount-input" name="amount_${index}" value="${parseFloat(amount).toFixed(2)}" required>
                            </td>
                        `;
                        categoriesBody.appendChild(row);
                    });

                    noCategories.classList.add('d-none');
                    categoriesTable.classList.remove('d-none');
                    validateBtn.disabled = false;
                } else {
                    noCategories.textContent = 'Aucune catégorie détectée.';
                    noCategories.classList.remove('d-none');
                    validateBtn.disabled = true;
                }
            })
            .catch(() => {
                noCategories.textContent = 'Erreur pendant l’analyse.';
                validateBtn.disabled = true;
            })
            .finally(() => {
                analyzeBtn.textContent = 'Analyser la facture';
                analyzeBtn.disabled = false;
            });
    });

    form.addEventListener('submit', e => {
        e.preventDefault();

        const formData = new FormData(form);

        // Recollecter les données modifiées
        const categories = [];
        const rows = categoriesBody.querySelectorAll('tr');
        rows.forEach(row => {
            const catInput = row.querySelector('.category-input');
            const amountInput = row.querySelector('.amount-input');
            if (catInput && amountInput) {
                categories.push({
                    category: catInput.value,
                    amount_ht: parseFloat(amountInput.value)
                });
            }
        });

        formData.append('categories', JSON.stringify(categories));
        formData.append('invoice_date', dateInput.value);

        fetch('/api/invoices', {
            method: 'POST',
            body: formData
        }).then(() => location.reload());
    });
}