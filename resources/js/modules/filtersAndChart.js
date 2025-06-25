import Chart from 'chart.js/auto';

export default function initFiltersAndChart() {

    function generateColorFromString(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        const color = '#' + ((hash >> 24) & 0xFF).toString(16).padStart(2, '0') +
                            ((hash >> 16) & 0xFF).toString(16).padStart(2, '0') +
                            ((hash >> 8) & 0xFF).toString(16).padStart(2, '0');
        return color;
    }

    const form = document.getElementById('filters-form');
    const pieCanvas = document.getElementById('expenses-chart');
    const barCanvas = document.getElementById('monthly-expenses-chart');
    const yearSelect = document.getElementById('year-select');

    if (!form || !pieCanvas || !barCanvas || !yearSelect) return;

    const pieCtx = pieCanvas.getContext('2d');
    const barCtx = barCanvas.getContext('2d');

    let pieChart = null;
    let barChart = null;

    const fetchPieData = () => {
        const params = new URLSearchParams(new FormData(form));
        fetch(`/api/factures?${params.toString()}`)
            .then(res => res.json())
            .then(response => {
                const data = response.data;
                console.log('Pie chart data:', data);

                const sorted = [...data].sort((a, b) => b.amount - a.amount);
                const top5 = sorted.slice(0, 5);
                const others = sorted.slice(5);

                const othersAmount = others.reduce((sum, item) => sum + item.amount, 0);
                const othersColor = '#999999';

                const finalLabels = [...top5.map(i => i.category)];
                const finalValues = [...top5.map(i => i.amount)];
                const finalColors = top5.map(i => i.color || generateColorFromString(i.category));

                if (others.length > 0) {
                    finalLabels.push('Autres');
                    finalValues.push(othersAmount);
                    finalColors.push(othersColor);
                }

                if (pieChart) pieChart.destroy();

                pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: finalLabels,
                        datasets: [{
                            data: finalValues,
                            backgroundColor: finalColors
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const value = context.parsed;
                                        return `${context.label}: ${value.toFixed(2)} €`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
    };

    const fetchMonthlyData = () => {
        const params = new URLSearchParams(new FormData(form));
        params.append('year', yearSelect.value);

        fetch(`/api/factures-mensuelles?${params.toString()}`)
            .then(res => res.json())
            .then(response => {
                console.log('Monthly raw response:', response);

                const labels = response.labels;
                const rawDatasets = response.datasets;

                if (!Array.isArray(labels) || !Array.isArray(rawDatasets)) {
                    console.warn('Bad format for labels or datasets', labels, rawDatasets);
                    return;
                }

                const cleanDatasets = rawDatasets
                    .filter(ds => Array.isArray(ds.data))
                    .map(ds => ({
                        label: ds.label,
                        total: ds.data.reduce((a, b) => (typeof b === 'number' ? a + b : a), 0),
                        backgroundColor: ds.backgroundColor || generateColorFromString(ds.label),
                        data: ds.data
                    }));

                console.log('Cleaned datasets (before trim):', cleanDatasets);

                const sorted = cleanDatasets.sort((a, b) => b.total - a.total);
                const top5 = sorted.slice(0, 5);
                const others = sorted.slice(5);

                const othersData = Array(labels.length).fill(0);
                others.forEach(ds => {
                    ds.data.forEach((val, i) => {
                        if (typeof val === 'number') {
                            othersData[i] += val;
                        }
                    });
                });

                const datasets = [...top5];

                if (others.length > 0) {
                    datasets.push({
                        label: 'Autres',
                        data: othersData,
                        backgroundColor: '#999999'
                    });
                }

                console.log('Final bar chart datasets:', datasets);

                if (barChart) barChart.destroy();

                barChart = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: { mode: 'index', intersect: false }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: { stacked: true },
                            y: { stacked: true }
                        }
                    }
                });
            });
    };

    const refreshAll = () => {
        console.log('Refreshing all graphs...');
        fetchPieData();
        fetchMonthlyData();
    };

    ['card_id', 'date_from', 'date_to'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', refreshAll);
    });

    yearSelect.addEventListener('change', fetchMonthlyData);

    // Initial load
    refreshAll();
}