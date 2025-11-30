const tbody = document.querySelector('table tbody');
const sortKeySel = document.getElementById('sort-key');
const sortDirSel = document.getElementById('sort-dir');

if (tbody && sortKeySel && sortDirSel) {
    const rows = Array.from(tbody.querySelectorAll('tr'));
    console.log('Antall rader:', rows.length);

    const urgencyMap = {high: 3, medium: 2, low: 1};

    function getVal(tr, key) {
        if (key === 'pay') return parseFloat(tr.dataset.pay) || 0;
        if (key === 'urgency') return urgencyMap[tr.dataset.urgency] || 0;
        if (key === 'date') return tr.dataset.date || '';
        if (key === 'title') return tr.dataset.title || '';
        return '';
    }

    function applySort() {
        const key = sortKeySel.value;
        const dir = sortDirSel.value;

        console.log('Sorting by:', key, dir);

        const ordered = rows.slice().sort((a, b) => {
            const valA = getVal(a, key);
            const valB = getVal(b, key);

            let cmp;
            if (key === 'pay' || key === 'urgency') {
                cmp = valA - valB;
            } else if (key === 'date' || key === 'title') {
                cmp = valA.localeCompare(valB);
            } else {
                cmp = 0;
            }
            return dir === 'asc' ? cmp : -cmp;
        });

        ordered.forEach(tr => tbody.appendChild(tr));
        console.log('Sorting complete');
    }

    sortKeySel.addEventListener('change', applySort);
    sortDirSel.addEventListener('change', applySort);
    applySort();
}
