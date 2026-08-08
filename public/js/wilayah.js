function initWilayahDropdowns(config) {
    const provinsiEl = document.getElementById(config.provinsiEl);
    const kotaEl = document.getElementById(config.kotaEl);
    const kecamatanEl = document.getElementById(config.kecamatanEl);
    const kelurahanEl = document.getElementById(config.kelurahanEl);

    const oldData = config.oldData || {};

    function populateDatalist(selectElement) {
        const datalist = document.getElementById(`${selectElement.id}List`);
        if (!datalist) return;

        datalist.innerHTML = '';
        Array.from(selectElement.options).forEach(option => {
            if (option.value) {
                datalist.insertAdjacentHTML('beforeend', `<option value="${option.value}"></option>`);
            }
        });
    }

    function fetchAndFill(url, element, placeholder, selectedValue, callback) {
        element.innerHTML = `<option value="">Memuat...</option>`;
        const datalist = document.getElementById(`${element.id}List`);
        if (datalist) {
            datalist.innerHTML = '';
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let options = `<option value="">${placeholder}</option>`;
                if (Array.isArray(data)) {
                    data.forEach(item => {
                        let isSelected = (item.name === selectedValue) ? 'selected' : '';
                        options += `<option value="${item.name}" data-id="${item.id}" ${isSelected}>${item.name}</option>`;
                    });
                }
                element.innerHTML = options;
                populateDatalist(element);

                if (typeof callback === 'function') {
                    callback(data);
                }
            })
            .catch(error => {
                console.error('Gagal memuat data:', error);
                element.innerHTML = `<option value="">Gagal memuat data</option>`;
            });
    }

    // 1. Load Provinsi via Endpoint Lokal Laravel
    if (provinsiEl) {
        fetchAndFill('/api/wilayah/provinces', provinsiEl, '-- Pilih Provinsi --', oldData.provinsi, () => {
            if (oldData.provinsi) {
                for (let option of provinsiEl.options) {
                    if (option.value === oldData.provinsi) {
                        provinsiEl.value = option.value;
                        provinsiEl.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            }
        });

        provinsiEl.addEventListener('change', function () {
            let provId = this.options[this.selectedIndex].getAttribute('data-id');
            kotaEl.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
            kecamatanEl.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            kelurahanEl.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

            if (provId) {
                fetchAndFill(`/api/wilayah/regencies/${provId}`, kotaEl, '-- Pilih Kota/Kabupaten --', oldData.kota, () => {
                    if (oldData.kota) {
                        for (let option of kotaEl.options) {
                            if (option.value === oldData.kota) {
                                kotaEl.value = option.value;
                                kotaEl.dispatchEvent(new Event('change'));
                                break;
                            }
                        }
                    }
                });
            }
        });
    }

    // 2. Event Kota -> Kecamatan
    if (kotaEl) {
        kotaEl.addEventListener('change', function () {
            let regId = this.options[this.selectedIndex].getAttribute('data-id');
            kecamatanEl.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            kelurahanEl.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

            if (regId) {
                fetchAndFill(`/api/wilayah/districts/${regId}`, kecamatanEl, '-- Pilih Kecamatan --', oldData.kecamatan, () => {
                    if (oldData.kecamatan) {
                        for (let option of kecamatanEl.options) {
                            if (option.value === oldData.kecamatan) {
                                kecamatanEl.value = option.value;
                                kecamatanEl.dispatchEvent(new Event('change'));
                                break;
                            }
                        }
                    }
                });
            }
        });
    }

    // 3. Event Kecamatan -> Kelurahan
    if (kecamatanEl) {
        kecamatanEl.addEventListener('change', function () {
            let distId = this.options[this.selectedIndex].getAttribute('data-id');
            kelurahanEl.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';

            if (distId) {
                fetchAndFill(`/api/wilayah/villages/${distId}`, kelurahanEl, '-- Pilih Kelurahan/Desa --', oldData.kelurahan);
            }
        });
    }
}