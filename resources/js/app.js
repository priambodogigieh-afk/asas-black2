import Chart from 'chart.js/auto';

const tempSeries = {
    hot: [70, 70.4, 69.8, 70.2, 70.1, 69.7, 70.3, 70],
    cold: [28, 28.2, 27.8, 28.1, 28.3, 27.9, 28.1, 28],
    mixed: [45, 44.8, 45.2, 45.1, 44.9, 45.3, 45, 45.1],
};

const defaultSensorState = {
    suhu_panas: 70,
    suhu_dingin: 28,
    suhu_campuran: 45,
    updated_at: null,
};

let sensorState = { ...defaultSensorState };
const realtimeCharts = [];

const chartColors = {
    hot: '#eb1446',
    cold: '#06f9b8',
    mixed: '#ffb300',
    grid: 'rgba(177, 206, 231, 0.20)',
    text: '#ebf3f9',
};

function setupLoginForm() {
    const form = document.querySelector('[data-login-form]');

    if (!form) {
        return;
    }
}

function setupRegisterForm() {
    const form = document.querySelector('[data-register-form]');

    if (!form) {
        return;
    }

    const status = document.querySelector('[data-register-status]');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const data = new FormData(form);
        const password = String(data.get('password') || '');
        const passwordConfirm = String(data.get('passwordConfirm') || '');

        if (password !== passwordConfirm) {
            status.textContent = 'Password dan konfirmasi password belum sama.';
            status.className = 'rounded-lg bg-[#fde8ed] px-4 py-3 text-xs font-bold text-[#8d0c2a]';
            return;
        }

        const account = {
            name: data.get('name'),
            email: data.get('email'),
            className: data.get('className'),
            nis: data.get('nis'),
            major: data.get('major'),
            createdAt: new Date().toISOString(),
        };

        localStorage.setItem('asas-black-student-account', JSON.stringify(account));
        status.textContent = `Akun ${account.name} berhasil dibuat secara dummy. Email: ${account.email}, NIS: ${account.nis}, Kelas: ${account.className}, Jurusan: ${account.major}.`;
        status.className = 'rounded-lg bg-[#e6fef8] px-4 py-3 text-xs font-bold text-[#03634a]';
    });
}

function setupLogoutConfirmation() {
    const forms = document.querySelectorAll('[data-logout-form]');

    if (!forms.length) {
        return;
    }

    let selectedForm = null;
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-[100] hidden items-center justify-center bg-[#013225]/45 px-4 backdrop-blur-sm';
    modal.innerHTML = `
        <div class="w-full max-w-sm rounded-lg border border-[#cdfef1] bg-white p-6 text-[#111827] shadow-2xl">
            <div class="flex items-start gap-3">
                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#fff7e5] text-[#996b00]">
                    <span class="material-symbols-outlined text-[22px]">logout</span>
                </div>
                <div>
                    <h2 class="text-lg font-black">Logout akun?</h2>
                    <p class="mt-1 text-sm font-semibold text-[#4b5563]">Apakah Anda yakin ingin keluar dari aplikasi?</p>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-2 gap-3">
                <button type="button" data-logout-cancel class="rounded-md border border-[#cdfef1] bg-white px-4 py-3 text-sm font-black text-[#013225] transition hover:bg-[#e6fef8]">Tidak</button>
                <button type="button" data-logout-confirm class="rounded-md bg-[#006c4e] px-4 py-3 text-sm font-black text-white transition hover:bg-[#013225]">Ya</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        selectedForm = null;
    };

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            selectedForm = form;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    modal.querySelector('[data-logout-cancel]')?.addEventListener('click', closeModal);
    modal.querySelector('[data-logout-confirm]')?.addEventListener('click', () => {
        selectedForm?.submit();
    });
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && selectedForm) {
            closeModal();
        }
    });
}

function setupSidebarToggle() {
    const sidebar = document.querySelector('[data-sidebar]');
    const content = document.querySelector('[data-dashboard-content]');
    const hideButton = document.querySelector('[data-sidebar-hide]');
    const showButton = document.querySelector('[data-sidebar-show]');

    if (!sidebar || !content || !hideButton || !showButton) {
        return;
    }

    const setHidden = (isHidden) => {
        sidebar.classList.toggle('-translate-x-full', isHidden);
        content.classList.toggle('lg:ml-64', !isHidden);
        content.classList.toggle('lg:ml-0', isHidden);
        showButton.classList.toggle('hidden', !isHidden);
        showButton.classList.toggle('grid', isHidden);
        localStorage.setItem('asas-black-sidebar-hidden', isHidden ? '1' : '0');
    };

    setHidden(localStorage.getItem('asas-black-sidebar-hidden') === '1');

    hideButton.addEventListener('click', () => setHidden(true));
    showButton.addEventListener('click', () => setHidden(false));
}

function nextValue(values) {
    const last = values[values.length - 1];
    const jitter = (Math.random() - 0.5) * 0.7;
    return Number((last + jitter).toFixed(1));
}

function getSensorValue(key) {
    const value = Number(sensorState[key]);

    if (Number.isFinite(value)) {
        return value;
    }

    return defaultSensorState[key];
}

function makeTemperatureChart(canvasId) {
    const canvas = document.getElementById(canvasId);

    if (!canvas || typeof Chart === 'undefined') {
        return null;
    }

    const labels = ['00:01', '00:02', '00:03', '00:04', '00:05', '00:06', '00:07', '00:08'];

    const chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Suhu Panas',
                    data: [...tempSeries.hot],
                    borderColor: chartColors.hot,
                    backgroundColor: 'rgba(235, 20, 70, 0.12)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
                {
                    label: 'Suhu Dingin',
                    data: [...tempSeries.cold],
                    borderColor: chartColors.cold,
                    backgroundColor: 'rgba(6, 249, 184, 0.10)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
                {
                    label: 'Suhu Campuran',
                    data: [...tempSeries.mixed],
                    borderColor: chartColors.mixed,
                    backgroundColor: 'rgba(255, 179, 0, 0.10)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 850,
                easing: 'easeOutQuart',
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    labels: {
                        color: chartColors.text,
                        usePointStyle: true,
                        boxWidth: 8,
                        font: {
                            weight: 'bold',
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.dataset.label}: ${context.formattedValue} C`,
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        color: chartColors.grid,
                    },
                    ticks: {
                        color: chartColors.text,
                        font: {
                            weight: 'bold',
                        },
                    },
                },
                y: {
                    suggestedMin: 20,
                    suggestedMax: 78,
                    grid: {
                        color: chartColors.grid,
                    },
                    ticks: {
                        color: chartColors.text,
                        callback: (value) => `${value} C`,
                    },
                },
            },
        },
    });

    realtimeCharts.push(chart);

    return chart;
}

function setupCharts() {
    ['teacherRealtimeChart', 'studentRealtimeChart', 'monitoringChart'].forEach(makeTemperatureChart);
}

function setupTemperatureJitter() {
    if (document.querySelector('[data-realtime-sensor-dashboard]')) {
        return;
    }

    const values = document.querySelectorAll('[data-temp-value]');

    if (!values.length) {
        return;
    }

    setInterval(() => {
        values.forEach((element) => {
            const base = Number(element.dataset.base || element.textContent || 0);
            const jitter = (Math.random() - 0.5) * 0.8;
            element.textContent = (base + jitter).toFixed(1);
        });
    }, 1800);
}

function formatJoules(value) {
    return `${Math.round(value).toLocaleString('id-ID')} J`;
}

function roundTemperatureForCalculation(value) {
    const number = Number(value);

    if (!Number.isFinite(number)) {
        return 0;
    }

    return Number(number.toFixed(1));
}

function calculateAsasBlack(form) {
    const hotMass = Number(form.elements.hotMass?.value || 0);
    const coldMass = Number(form.elements.coldMass?.value || 0);
    const hasValidInput = hotMass > 0 && coldMass > 0;
    const t1 = roundTemperatureForCalculation(form.elements.suhuPanas?.value || getSensorValue('suhu_panas'));
    const t2 = roundTemperatureForCalculation(form.elements.suhuDingin?.value || getSensorValue('suhu_dingin'));
    const tc = roundTemperatureForCalculation(form.elements.suhuCampuran?.value || getSensorValue('suhu_campuran'));
    const c = 4200;
    const qRelease = hasValidInput ? hotMass * c * (t1 - tc) : 0;
    const qAccept = hasValidInput ? coldMass * c * (tc - t2) : 0;
    const average = (qRelease + qAccept) / 2 || 1;
    const errorPercent = Math.abs(qRelease - qAccept) / average * 100;
    const isValid = hasValidInput && errorPercent < 10;
    const container = form.closest('[data-page]') || document;

    container.querySelectorAll('[data-q-release]').forEach((item) => {
        item.textContent = formatJoules(qRelease);
    });

    container.querySelectorAll('[data-q-accept]').forEach((item) => {
        item.textContent = formatJoules(qAccept);
    });

    container.querySelectorAll('[data-delta-q]').forEach((item) => {
        item.textContent = hasValidInput ? formatJoules(Math.abs(qRelease - qAccept)) : '-';
    });

    container.querySelectorAll('[data-error-percent]').forEach((item) => {
        item.textContent = hasValidInput ? `${errorPercent.toFixed(2)}%` : '-';
    });

    container.querySelectorAll('[data-asas-status]').forEach((item) => {
        item.textContent = hasValidInput ? (isValid ? 'SESUAI HUKUM ASAS BLACK' : 'TIDAK SESUAI') : 'Masukkan massa valid';
        item.classList.toggle('text-[#04956e]', isValid);
        item.classList.toggle('dark:text-[#9cfce3]', isValid);
        item.classList.toggle('text-[#eb1446]', hasValidInput && !isValid);
        item.classList.toggle('dark:text-[#f7a1b5]', hasValidInput && !isValid);
        item.classList.toggle('text-[#0c1a27]', !hasValidInput);
        item.classList.toggle('dark:text-[#ebf3f9]', !hasValidInput);
    });

    container.querySelectorAll('[data-asas-status-pill]').forEach((item) => {
        item.classList.toggle('border-[#9cfce3]', isValid);
        item.classList.toggle('bg-[#e6fef8]', isValid);
        item.classList.toggle('text-[#03634a]', isValid);
        item.classList.toggle('border-[#f7a1b5]', hasValidInput && !isValid);
        item.classList.toggle('bg-[#fde8ed]', hasValidInput && !isValid);
        item.classList.toggle('text-[#8d0c2a]', hasValidInput && !isValid);
        item.classList.toggle('border-[#d8e6f3]', !hasValidInput);
        item.classList.toggle('bg-[#ffffff]', !hasValidInput);
        item.classList.toggle('text-[#0c1a27]', !hasValidInput);
    });

    container.querySelectorAll('[data-asas-note]').forEach((item) => {
        item.textContent = hasValidInput
            ? `Rumus aktif: ${hotMass} x 4200 x (${t1.toFixed(1)} - ${tc.toFixed(1)}) dibandingkan ${coldMass} x 4200 x (${tc.toFixed(1)} - ${t2.toFixed(1)}).`
            : 'Isi massa air panas dan massa air dingin lebih dari 0 kg untuk menghitung.';
    });

    return {
        hotMass,
        coldMass,
        qRelease,
        qAccept,
        deltaQ: Math.abs(qRelease - qAccept),
        errorPercent,
        suhuPanas: t1,
        suhuDingin: t2,
        suhuCampuran: tc,
        status: isValid ? 'SESUAI HUKUM ASAS BLACK' : 'TIDAK SESUAI',
        hasValidInput,
    };
}

async function savePraktikumHistory(form, result) {
    const saveUrl = form.dataset.saveUrl;
    const container = form.closest('[data-page]') || document;
    const status = container.querySelector('[data-save-status]');

    if (!saveUrl || !status) {
        return;
    }

    if (!result.hasValidInput) {
        status.textContent = 'Riwayat belum disimpan karena massa air belum valid.';
        status.className = 'mt-3 rounded-lg bg-[#fde8ed] px-4 py-3 text-xs font-bold text-[#8d0c2a]';
        return;
    }

    status.textContent = 'Menyimpan riwayat praktikum ke database...';
    status.className = 'mt-3 rounded-lg bg-[#e6fef8] px-4 py-3 text-xs font-bold text-[#03634a]';

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const payload = {
        massa_panas: result.hotMass,
        massa_dingin: result.coldMass,
        q_lepas: result.qRelease,
        q_terima: result.qAccept,
        delta_q: result.deltaQ,
        error_persen: result.errorPercent,
        status: result.status,
        suhu_panas: result.suhuPanas,
        suhu_dingin: result.suhuDingin,
        suhu_campuran: result.suhuCampuran,
    };

    try {
        const response = await fetch(saveUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify(payload),
        });

        if (response.status === 401) {
            status.textContent = 'Silakan login sebagai siswa agar riwayat tersimpan.';
            status.className = 'mt-3 rounded-lg bg-[#fde8ed] px-4 py-3 text-xs font-bold text-[#8d0c2a]';
            return;
        }

        if (!response.ok) {
            throw new Error('save failed');
        }

        const data = await response.json();
        status.textContent = `${data.message} ID riwayat: ${data.history_id}.`;
        status.className = 'mt-3 rounded-lg bg-[#e6fef8] px-4 py-3 text-xs font-bold text-[#03634a]';
    } catch (error) {
        status.textContent = 'Riwayat gagal disimpan. Periksa koneksi backend dan coba lagi.';
        status.className = 'mt-3 rounded-lg bg-[#fde8ed] px-4 py-3 text-xs font-bold text-[#8d0c2a]';
    }
}

function formatTemperature(value, fallback = '--') {
    const number = Number(value);

    if (!Number.isFinite(number)) {
        return fallback;
    }

    return number.toFixed(1);
}

function pushRealtimeChartPoint() {
    if (!realtimeCharts.length) {
        return;
    }

    const date = new Date();
    const label = `${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`;
    const values = [
        getSensorValue('suhu_panas'),
        getSensorValue('suhu_dingin'),
        getSensorValue('suhu_campuran'),
    ];

    realtimeCharts.forEach((chart) => {
        chart.data.labels.push(label);
        chart.data.labels.shift();

        chart.data.datasets.forEach((dataset, index) => {
            dataset.data.push(values[index]);
            dataset.data.shift();
        });

        chart.update();
    });
}

function updateSensorInterface(reading) {
    sensorState = {
        suhu_panas: reading.suhu_panas ?? sensorState.suhu_panas,
        suhu_dingin: reading.suhu_dingin ?? sensorState.suhu_dingin,
        suhu_campuran: reading.suhu_campuran ?? sensorState.suhu_campuran,
        updated_at: reading.updated_at ?? sensorState.updated_at,
    };

    ['suhu_panas', 'suhu_dingin', 'suhu_campuran'].forEach((key) => {
        const value = getSensorValue(key);

        document.querySelectorAll(`[data-sensor-value="${key}"]`).forEach((element) => {
            element.textContent = formatTemperature(value);
            element.dataset.base = String(value);
        });

        document.querySelectorAll(`[data-sensor-bar="${key}"]`).forEach((element) => {
            element.style.width = `${Math.min(100, Math.max(8, value))}%`;
        });

        document.querySelectorAll(`[data-sensor-drift="${key}"]`).forEach((element) => {
            element.textContent = reading.updated_at ? 'Live MQTT' : 'Fallback';
        });
    });

    document.querySelectorAll('[data-suhu-panas-input]').forEach((input) => {
        input.value = formatTemperature(getSensorValue('suhu_panas'));
    });

    document.querySelectorAll('[data-suhu-dingin-input]').forEach((input) => {
        input.value = formatTemperature(getSensorValue('suhu_dingin'));
    });

    document.querySelectorAll('[data-suhu-campuran-input]').forEach((input) => {
        input.value = formatTemperature(getSensorValue('suhu_campuran'));
    });

    document.querySelectorAll('[data-sensor-status]').forEach((element) => {
        element.textContent = reading.updated_at ? 'Connected - Sensor Active' : 'Menunggu data MQTT';
    });

    document.querySelectorAll('[data-sensor-updated]').forEach((element) => {
        element.textContent = `Updated: ${reading.updated_at || '-'}`;
    });

    document.querySelectorAll('[data-asas-form]').forEach(calculateAsasBlack);
    pushRealtimeChartPoint();
}

async function fetchLatestSensorReading() {
    try {
        const response = await fetch('/api/sensor/latest', {
            headers: {
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Sensor endpoint failed');
        }

        updateSensorInterface(await response.json());
    } catch (error) {
        updateSensorInterface({
            ...sensorState,
            updated_at: null,
        });
    }
}

function setupMqttConnectButtons() {
    document.querySelectorAll('[data-mqtt-connect-button]').forEach((button) => {
        button.addEventListener('click', async () => {
            const originalLabel = button.innerHTML;
            const container = button.closest('[data-realtime-sensor-dashboard]') || document;
            const message = container.querySelector('[data-mqtt-connect-message]');
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            button.disabled = true;
            button.classList.add('opacity-70');
            button.innerHTML = '<span class="material-symbols-outlined text-[20px]">sync</span>Menghubungkan...';

            if (message) {
                message.textContent = 'Menjalankan php artisan mqtt:subscribe...';
            }

            try {
                const response = await fetch('/mqtt/connect', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({}),
                });

                if (!response.ok) {
                    throw new Error('Gagal menjalankan subscriber MQTT');
                }

                const data = await response.json();

                if (message) {
                    message.textContent = data.message || 'Subscriber MQTT sudah dijalankan.';
                }

                fetchLatestSensorReading();
            } catch (error) {
                if (message) {
                    message.textContent = 'Gagal menjalankan MQTT. Pastikan server Laravel punya izin menjalankan proses.';
                }
            } finally {
                setTimeout(() => {
                    button.disabled = false;
                    button.classList.remove('opacity-70');
                    button.innerHTML = originalLabel;
                }, 1200);
            }
        });
    });
}

function setupRealtimeSensorPolling() {
    if (!document.querySelector('[data-realtime-sensor-dashboard]')) {
        return;
    }

    updateSensorInterface(sensorState);
    fetchLatestSensorReading();
    setInterval(fetchLatestSensorReading, 2000);
}

function setupAsasBlackCalculator() {
    document.querySelectorAll('[data-asas-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const result = calculateAsasBlack(form);
            savePraktikumHistory(form, result);
        });

        form.querySelectorAll('input').forEach((input) => {
            input.addEventListener('input', () => calculateAsasBlack(form));
        });

        form.querySelector('[data-reset-asas]')?.addEventListener('click', () => {
            form.elements.hotMass.value = '0.25';
            form.elements.coldMass.value = '0.35';
            calculateAsasBlack(form);
        });

        calculateAsasBlack(form);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupLoginForm();
    setupRegisterForm();
    setupLogoutConfirmation();
    setupSidebarToggle();
    setupCharts();
    setupTemperatureJitter();
    setupAsasBlackCalculator();
    setupMqttConnectButtons();
    setupRealtimeSensorPolling();
});
