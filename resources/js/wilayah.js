function initWilayahDropdowns(config) {
    const {
        provinsiEl,
        kotaEl,
        kecamatanEl,
        kelurahanEl,
        oldData
    } = config;

    const selects = {
        provinsi: document.getElementById(provinsiEl),
        kota: document.getElementById(kotaEl),
        kecamatan: document.getElementById(kecamatanEl),
        kelurahan: document.getElementById(kelurahanEl),
    };

    const setSelectsDisabled = (disabled) => {
        Object.values(selects).forEach(select => {
            if (select) select.disabled = disabled;
        });
    };

    async function fetchAndPopulate(url, selectElement, selectedValue) {
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();

            const placeholder = selectElement.querySelector('option[value=""]');
            selectElement.innerHTML = '';
            if (placeholder) selectElement.appendChild(placeholder);

            let selectedOptionId = null;
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.nama;
                option.dataset.id = item.id;
                option.textContent = item.nama;
                selectElement.appendChild(option);

                if (item.nama === selectedValue) {
                    option.selected = true;
                    selectedOptionId = item.id;
                }
            });

            return selectedOptionId;
        } catch (error) {
            console.error(`Error fetching data for ${selectElement.id}:`, error);
            return null;
        }
    }

    function clearSelect(selectElement) {
        if (selectElement) {
            const placeholder = selectElement.querySelector('option[value=""]');
            selectElement.innerHTML = '';
            if (placeholder) selectElement.appendChild(placeholder);
        }
    }

    async function loadInitialData() {
        setSelectsDisabled(true);

        const provinceId = await fetchAndPopulate('/api/get-provinces', selects.provinsi, oldData.provinsi);
        if (provinceId && oldData.kota) {
            const cityId = await fetchAndPopulate(`/api/get-cities?province_id=${provinceId}`, selects.kota, oldData.kota);
            if (cityId && oldData.kecamatan) {
                const districtId = await fetchAndPopulate(`/api/get-districts?city_id=${cityId}`, selects.kecamatan, oldData.kecamatan);
                if (districtId && oldData.kelurahan) {
                    await fetchAndPopulate(`/api/get-villages?district_id=${districtId}`, selects.kelurahan, oldData.kelurahan);
                }
            }
        }

        setSelectsDisabled(false);
    }

    selects.provinsi.addEventListener('change', function() {
        const provinceId = this.options[this.selectedIndex]?.dataset.id;
        clearSelect(selects.kota);
        clearSelect(selects.kecamatan);
        clearSelect(selects.kelurahan);
        if (provinceId) {
            fetchAndPopulate(`/api/get-cities?province_id=${provinceId}`, selects.kota);
        }
    });

    selects.kota.addEventListener('change', function() {
        const cityId = this.options[this.selectedIndex]?.dataset.id;
        clearSelect(selects.kecamatan);
        clearSelect(selects.kelurahan);
        if (cityId) {
            fetchAndPopulate(`/api/get-districts?city_id=${cityId}`, selects.kecamatan);
        }
    });

    selects.kecamatan.addEventListener('change', function() {
        const districtId = this.options[this.selectedIndex]?.dataset.id;
        clearSelect(selects.kelurahan);
        if (districtId) {
            fetchAndPopulate(`/api/get-villages?district_id=${districtId}`, selects.kelurahan);
        }
    });

    loadInitialData();
}