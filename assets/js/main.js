/**
 * ButuhUang Frontend JavaScript
 * Dynamic interactive features: Loan Calculator, Sliders, Tab Switching, Payment Modal
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Interactive Loan Slider Setup
    const nominalSlider = document.getElementById('nominalSlider');
    const tenorSlider = document.getElementById('tenorSlider');
    const nominalDisplay = document.getElementById('nominalDisplay');
    const tenorDisplay = document.getElementById('tenorDisplay');
    const cicilanDisplay = document.getElementById('cicilanDisplay');
    const totalDisplay = document.getElementById('totalDisplay');

    function formatNumberLabel(val) {
        val = parseInt(val);
        if (val >= 1000000) {
            const juta = val / 1000000;
            return juta % 1 === 0 ? `${juta} Juta` : `${juta.toFixed(1)} Juta`;
        } else if (val >= 1000) {
            return `${(val / 1000)} Ribu`;
        }
        return val.toLocaleString('id-ID');
    }

    function formatRupiah(val) {
        return 'Rp ' + Math.round(val).toLocaleString('id-ID');
    }

    function updateSliderBackground(slider) {
        if (!slider) return;
        const min = slider.min || 0;
        const max = slider.max || 100;
        const val = slider.value;
        const percentage = ((val - min) / (max - min)) * 100;
        slider.style.background = `linear-gradient(to right, #38bdf8 0%, #38bdf8 ${percentage}%, #ffffff ${percentage}%, #ffffff 100%)`;
    }

    function updateLoanCalculations() {
        if (!nominalSlider || !tenorSlider) return;

        const nominal = parseFloat(nominalSlider.value);
        const tenor = parseInt(tenorSlider.value);
        
        // Update Labels
        if (nominalDisplay) nominalDisplay.textContent = formatNumberLabel(nominal);
        if (tenorDisplay) tenorDisplay.textContent = `${tenor} Bulan`;

        // Update Slider Fills
        updateSliderBackground(nominalSlider);
        updateSliderBackground(tenorSlider);

        // Calculate Interest & Installment (Bunga flat misal 0.8% per bulan, maks 10% pertahun)
        const bungaPerBulan = 0.008; 
        const totalBunga = nominal * (bungaPerBulan * tenor);
        const totalPengembalian = nominal + totalBunga;
        const cicilanPerBulan = totalPengembalian / tenor;

        if (cicilanDisplay) cicilanDisplay.textContent = formatRupiah(cicilanPerBulan) + ' / bulan';
        if (totalDisplay) totalDisplay.textContent = formatRupiah(totalPengembalian);
    }

    if (nominalSlider && tenorSlider) {
        nominalSlider.addEventListener('input', updateLoanCalculations);
        tenorSlider.addEventListener('input', updateLoanCalculations);
        updateLoanCalculations();
    }

    // 2. Tab Switching for Tagihan Page
    const tabButtons = document.querySelectorAll('.tagihan-tab-btn');
    const tabContents = document.querySelectorAll('.tagihan-tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const targetTab = btn.getAttribute('data-tab');

            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.style.display = 'none');

            btn.classList.add('active');
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.style.display = 'block';
            }
        });
    });

    // 3. Payment Modal Handlers
    window.openPaymentModal = function(billId, nominal, bulanKe) {
        const modal = document.getElementById('paymentModal');
        const modalBillId = document.getElementById('modalBillId');
        const modalNominal = document.getElementById('modalNominal');
        const modalBulan = document.getElementById('modalBulan');

        if (modal) {
            if (modalBillId) modalBillId.value = billId;
            if (modalNominal) modalNominal.textContent = formatRupiah(nominal);
            if (modalBulan) modalBulan.textContent = `Bulan ke-${bulanKe}`;
            modal.classList.add('active');
        }
    };

    window.closePaymentModal = function() {
        const modal = document.getElementById('paymentModal');
        if (modal) modal.classList.remove('active');
    };
});
