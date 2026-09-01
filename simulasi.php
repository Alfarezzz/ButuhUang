<?php
$pageTitle = "Simulasi Pinjaman";
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: #f8fafc; padding: 3.5rem 1.5rem 6rem;">
    <div style="max-width: 1050px; margin: 0 auto;">
        <!-- HEADER -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 class="page-title" style="margin-bottom: 0.8rem;">Kalkulator Simulasi Pinjaman</h1>
            <p style="color: #64748b; font-size: 1.05rem; max-width: 650px; margin: 0 auto;">
                Hitung estimasi angsuran bulanan dan rincian bunga transparan sebelum Anda mengajukan pinjaman di <strong>ButuhUang</strong>.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 2.5rem; align-items: start;">
            <!-- KALKULATOR SLIDERS (KIRI) -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; padding: 2.2rem; box-shadow: var(--shadow-sm);">
                <h2 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 1.8rem; display: flex; align-items: center; gap: 10px;">
                    <img src="assets/images/icon-pinjaman.svg" alt="Simulasi" style="width: 28px; height: 28px;">
                    <span>Atur Jumlah & Tenor Pinjaman</span>
                </h2>

                <!-- SLIDER NOMINAL -->
                <div class="form-group" style="margin-bottom: 2.5rem;">
                    <div class="slider-group-header">
                        <span class="slider-label">Nominal Pinjaman</span>
                        <span class="slider-val-badge" id="simNominalDisplay">3 Juta</span>
                    </div>
                    <input type="range" id="simNominalSlider" class="custom-range-slider" 
                           min="500000" max="20000000" step="500000" value="3000000">
                    <div style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #94a3b8; margin-top: -1.5rem;">
                        <span>Rp 500 Ribu</span>
                        <span>Rp 20 Juta</span>
                    </div>
                </div>

                <!-- SLIDER TENOR -->
                <div class="form-group" style="margin-bottom: 2rem;">
                    <div class="slider-group-header">
                        <span class="slider-label">Jangka Waktu (Tenor)</span>
                        <span class="slider-val-badge" id="simTenorDisplay">6 Bulan</span>
                    </div>
                    <input type="range" id="simTenorSlider" class="custom-range-slider" 
                           min="1" max="12" step="1" value="6">
                    <div style="display: flex; justify-content: space-between; font-size: 0.82rem; color: #94a3b8; margin-top: -1.5rem;">
                        <span>1 Bulan</span>
                        <span>12 Bulan</span>
                    </div>
                </div>

                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 1rem; color: #166534; font-size: 0.88rem; display: flex; gap: 10px; align-items: center;">
                    <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Suku bunga flat kompetitif <strong>0.8% / bulan</strong> (Maksimum 9.6% per tahun). Tanpa biaya provisi tersembunyi.</span>
                </div>
            </div>

            <!-- HASIL SIMULASI (KANAN) -->
            <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; padding: 2.2rem; box-shadow: var(--shadow-sm);">
                <h2 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">
                    Estimasi Angsuran Bulanan
                </h2>

                <div style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; border-radius: 16px; padding: 1.8rem; text-align: center; margin-bottom: 1.8rem;">
                    <div style="font-size: 0.9rem; color: #bae6fd; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Cicilan per Bulan</div>
                    <div id="simCicilanDisplay" style="font-size: 2.2rem; font-weight: 800; margin: 0.4rem 0;">Rp 524.000</div>
                    <div style="font-size: 0.85rem; color: #e0f2fe;">Termasuk Pokok + Bunga</div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.85rem; border-bottom: 1.5px dashed #e2e8f0; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                        <span style="color: #64748b;">Pokok Pinjaman:</span>
                        <strong id="simPokokDisplay" style="color: #0f172a;">Rp 3.000.000</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.95rem;">
                        <span style="color: #64748b;">Total Bunga Pinjaman:</span>
                        <strong id="simBungaDisplay" style="color: #0284c7;">Rp 144.000</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 1rem; padding-top: 0.5rem; border-top: 1px solid #f1f5f9;">
                        <span style="font-weight: 700; color: #0f172a;">Total Pengembalian:</span>
                        <strong id="simTotalDisplay" style="font-size: 1.15rem; color: #0f172a;">Rp 3.144.000</strong>
                    </div>
                </div>

                <a href="pinjaman.php" id="btnAjukanSimulasi" class="btn-hero-primary" style="display: block; text-align: center; padding: 0.9rem; font-size: 1.05rem;">
                    Ajukan Pinjaman Ini Sekarang
                </a>
            </div>
        </div>

        <!-- TABEL RINCIAN JADWAL CICILAN BULANAN -->
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 20px; padding: 2.2rem; margin-top: 3rem; box-shadow: var(--shadow-sm);">
            <h2 style="font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem;">
                Tabel Rincian Jadwal Angsuran
            </h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                            <th style="padding: 1rem;">Bulan Ke</th>
                            <th style="padding: 1rem;">Pokok Angsuran</th>
                            <th style="padding: 1rem;">Bunga (0.8%)</th>
                            <th style="padding: 1rem;">Total Pembayaran</th>
                            <th style="padding: 1rem;">Sisa Pokok</th>
                        </tr>
                    </thead>
                    <tbody id="simTabelBody">
                        <!-- Diisi via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const simNominal = document.getElementById('simNominalSlider');
    const simTenor = document.getElementById('simTenorSlider');
    const simNominalDisplay = document.getElementById('simNominalDisplay');
    const simTenorDisplay = document.getElementById('simTenorDisplay');
    const simCicilanDisplay = document.getElementById('simCicilanDisplay');
    const simPokokDisplay = document.getElementById('simPokokDisplay');
    const simBungaDisplay = document.getElementById('simBungaDisplay');
    const simTotalDisplay = document.getElementById('simTotalDisplay');
    const simTabelBody = document.getElementById('simTabelBody');

    function formatRupiah(num) {
        return 'Rp ' + Math.round(num).toLocaleString('id-ID');
    }

    function formatJuta(val) {
        val = parseInt(val);
        if (val >= 1000000) {
            const jt = val / 1000000;
            return jt % 1 === 0 ? `${jt} Juta` : `${jt.toFixed(1)} Juta`;
        }
        return (val / 1000) + ' Ribu';
    }

    function updateSimulation() {
        const nominal = parseFloat(simNominal.value);
        const tenor = parseInt(simTenor.value);

        simNominalDisplay.textContent = formatJuta(nominal);
        simTenorDisplay.textContent = `${tenor} Bulan`;

        // Update Slider Fills
        const pctNominal = ((nominal - 500000) / (20000000 - 500000)) * 100;
        simNominal.style.background = `linear-gradient(to right, #38bdf8 0%, #38bdf8 ${pctNominal}%, #ffffff ${pctNominal}%, #ffffff 100%)`;

        const pctTenor = ((tenor - 1) / (12 - 1)) * 100;
        simTenor.style.background = `linear-gradient(to right, #38bdf8 0%, #38bdf8 ${pctTenor}%, #ffffff ${pctTenor}%, #ffffff 100%)`;

        const bungaRatePerBulan = 0.008;
        const totalBunga = nominal * (bungaRatePerBulan * tenor);
        const totalPengembalian = nominal + totalBunga;
        const cicilanPerBulan = totalPengembalian / tenor;
        const pokokPerBulan = nominal / tenor;
        const bungaPerBulan = totalBunga / tenor;

        simCicilanDisplay.textContent = formatRupiah(cicilanPerBulan);
        simPokokDisplay.textContent = formatRupiah(nominal);
        simBungaDisplay.textContent = formatRupiah(totalBunga);
        simTotalDisplay.textContent = formatRupiah(totalPengembalian);

        // Render Tabel Jadwal Angsuran
        let html = '';
        let sisaPokok = nominal;
        for (let i = 1; i <= tenor; i++) {
            sisaPokok -= pokokPerBulan;
            if (sisaPokok < 0 || i === tenor) sisaPokok = 0;
            html += `
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 0.9rem; font-weight: 700; color: #0284c7;">Bulan ke-${i}</td>
                    <td style="padding: 0.9rem;">${formatRupiah(pokokPerBulan)}</td>
                    <td style="padding: 0.9rem; color: #f59e0b;">${formatRupiah(bungaPerBulan)}</td>
                    <td style="padding: 0.9rem; font-weight: 700; color: #0f172a;">${formatRupiah(cicilanPerBulan)}</td>
                    <td style="padding: 0.9rem; color: #64748b;">${formatRupiah(sisaPokok)}</td>
                </tr>
            `;
        }
        simTabelBody.innerHTML = html;
    }

    simNominal.addEventListener('input', updateSimulation);
    simTenor.addEventListener('input', updateSimulation);
    updateSimulation();
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
