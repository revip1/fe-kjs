@extends('layouts.master')

@section('content')
<div class="container">
    {{-- Add CSRF token meta tag in your master layout head --}}
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2>HPS Header</h2>
            <form id="hpsHeaderForm" class="row">
                @csrf
                <div class="col-md-3 mb-3">
                    <label for="cargo_name" class="form-label">Nama Cargo</label>
                    <input type="text" name="cargo_name" id="cargo_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="consignee" class="form-label">Consignee</label>
                    <input type="text" name="consignee" id="consignee" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="vessel_name" class="form-label">Vessel Name</label>
                    <input type="text" name="vessel_name" id="vessel_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tonase" class="form-label">Tonase</label>
                    <input type="text" name="tonase" id="tonase" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="jumlah_gang" class="form-label">Jumlah Gang</label>
                    <input type="text" name="jumlah_gang" id="jumlah_gang" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="ldrate" class="form-label">L/D Rate</label>
                    <input type="text" name="ldrate" id="ldrate" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <input type="text" name="hari" id="hari" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="shift" class="form-label">Shift</label>
                    <input type="text" name="shift" id="shift" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="jam" class="form-label">Jam</label>
                    <input type="text" name="jam" id="jam" class="form-control form-control-sm" required>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2>Pricelist</h2>
            <div id="pricelistContainer">
                <div class="row align-items-end mb-3 pricelist-item" id="pricelist-item-0">
                    <div class="col-md-1 mb-3">
                        <label for="service_id_0" class="form-label">Jasa</label>
                        <select name="pricelists[0][service_id]" id="service_id_0" class="form-control form-control-sm service-select" required>
                            <option value="">Jasa</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" data-harga="{{ $service->harga }}">{{ $service->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="nama_0" class="form-label">Nama</label>
                        <input type="text" name="pricelists[0][nama]" id="nama_0" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="qty_0" class="form-label">Quantity</label>
                        <input type="number" name="pricelists[0][qty]" id="qty_0" class="form-control form-control-sm qty-input" required min="1">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="jml_pemakaian_0" class="form-label">Jumlah Pemakaian</label>
                        <input type="number" name="pricelists[0][jml_pemakaian]" id="jml_pemakaian_0" class="form-control form-control-sm jml-pemakaian-input" required min="1">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="price_0" class="form-label">Tarif</label>
                        <input type="number" name="pricelists[0][price]" id="price_0" class="form-control form-control-sm price-input" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="satuan_0" class="form-label">Satuan</label>
                        <select name="pricelists[0][satuan]" id="satuan_0" class="form-control form-control-sm" required>
                            <option value="ltr">Liter</option>
                            <option value="shift">Shift</option>
                            <option value="gang">Gang</option>
                            <option value="paket">Paket</option>
                            <option value="kapal">Kapal</option>
                            <option value="jam">Jam</option>
                            <option value="ton">Ton</option>
                            <option value="unit">Unit</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-3 d-flex align-items-end">
                        <div class="flex-grow-1 me-1">
                            <label for="total_0" class="form-label">Total</label>
                            <input type="number" name="pricelists[0][total]" id="total_0" class="form-control form-control-sm total-input" readonly>
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end mb-3">
                            <button type="button" class="btn btn-success btn-sm mb-1 add-pricelist-item">+</button>
                            <button type="button" class="btn btn-danger btn-sm remove-pricelist-item" style="display: none;">-</button>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-3">
        <button type="button" id="addToPreviewButton" class="btn btn-primary">Preview Data</button>
    </div>

    <div class="card shadow-sm mt-4" id="previewSection" style="display: none;">
        <div class="card-body">
            <h2>Preview</h2>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody id="previewBody">
                </tbody>
            </table>
            <div class="text-end">
                <button type="button" id="saveButton" class="btn btn-success">Save All Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewSection = document.getElementById('previewSection');
        const previewBody = document.getElementById('previewBody');
        const addToPreviewButton = document.getElementById('addToPreviewButton');
        const saveButton = document.getElementById('saveButton');
        const pricelistContainer = document.getElementById('pricelistContainer');

        let pricelistItemCount = 0; // Keep track of current count (0-indexed)

        // Function to calculate price and total for a specific pricelist item
        function calculatePriceAndTotal(itemElement) {
            const serviceSelect = itemElement.querySelector('.service-select');
            const qtyInput = itemElement.querySelector('.qty-input');
            const jmlPemakaianInput = itemElement.querySelector('.jml-pemakaian-input');
            const priceInput = itemElement.querySelector('.price-input');
            const totalInput = itemElement.querySelector('.total-input');

            // Ensure serviceSelect has a selected option
            if (!serviceSelect || serviceSelect.selectedIndex === -1 || !serviceSelect.options[serviceSelect.selectedIndex]) {
                priceInput.value = (0).toFixed(2);
                totalInput.value = (0).toFixed(2);
                return;
            }

            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const harga = parseFloat(selectedOption.dataset.harga || 0) || 0;
            const qty = parseFloat(qtyInput.value || 0) || 0;
            const jmlPemakaian = parseFloat(jmlPemakaianInput.value || 0) || 0;

            priceInput.value = harga.toFixed(2);
            totalInput.value = (harga * qty * jmlPemakaian).toFixed(2);
        }

        // Function to attach event listeners to a new pricelist item
        function attachPricelistListeners(itemElement) {
            const serviceSelect = itemElement.querySelector('.service-select');
            const qtyInput = itemElement.querySelector('.qty-input');
            const jmlPemakaianInput = itemElement.querySelector('.jml-pemakaian-input');
            const addButton = itemElement.querySelector('.add-pricelist-item');
            const removeButton = itemElement.querySelector('.remove-pricelist-item');

            if (serviceSelect) serviceSelect.addEventListener('change', () => calculatePriceAndTotal(itemElement));
            if (qtyInput) qtyInput.addEventListener('input', () => calculatePriceAndTotal(itemElement));
            if (jmlPemakaianInput) jmlPemakaianInput.addEventListener('input', () => calculatePriceAndTotal(itemElement));

            if (addButton) {
                addButton.addEventListener('click', () => {
                    addNewPricelistItem();
                });
            }

            if (removeButton) {
                removeButton.addEventListener('click', () => {
                    itemElement.remove();
                    updateButtonVisibility(); // Adjust visibility after removal
                });
            }

            // Initial calculation for the newly added item
            calculatePriceAndTotal(itemElement);
        }

        // Function to add a new pricelist item
        function addNewPricelistItem() {
            // Find the last pricelist item to clone
            const lastPricelistItem = pricelistContainer.lastElementChild;
            pricelistItemCount++; // Increment for the new item

            const newItem = lastPricelistItem.cloneNode(true); // Deep clone

            newItem.id = `pricelist-item-${pricelistItemCount}`;

            // Update IDs and names for the cloned elements
            newItem.querySelectorAll('[id]').forEach(element => {
                const oldId = element.id;
                const newId = oldId.replace(/_\d+$/, `_${pricelistItemCount}`);
                element.id = newId;

                // Update 'for' attribute of labels
                const label = document.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newId);
                }
            });

            newItem.querySelectorAll('[name]').forEach(element => {
                const oldName = element.name;
                // Replace the index in the name attribute
                const newName = oldName.replace(/pricelists\[\d+\]/, `pricelists[${pricelistItemCount}]`);
                element.name = newName;
            });

            // Reset values for cloned elements
            newItem.querySelectorAll('input').forEach(input => input.value = '');
            newItem.querySelector('.service-select').selectedIndex = 0; // Reset dropdown

            // Hide the '+' button on the *previous* last item
            lastPricelistItem.querySelector('.add-pricelist-item').style.display = 'none';

            pricelistContainer.appendChild(newItem);
            attachPricelistListeners(newItem); // Attach listeners to the new item
            updateButtonVisibility(); // Update visibility for all items
        }

        // Function to update the visibility of +/- buttons
        function updateButtonVisibility() {
            const allPricelistItems = document.querySelectorAll('.pricelist-item');

            // Hide all '+' buttons except for the last item
            allPricelistItems.forEach((item, index) => {
                const addButton = item.querySelector('.add-pricelist-item');
                const removeButton = item.querySelector('.remove-pricelist-item');

                if (index === allPricelistItems.length - 1) { // It's the last item
                    addButton.style.display = 'block'; // Show '+'
                } else {
                    addButton.style.display = 'none'; // Hide '+'
                }

                if (allPricelistItems.length > 1) { // More than one item
                    removeButton.style.display = 'block'; // Show '-'
                } else { // Only one item
                    removeButton.style.display = 'none'; // Hide '-'
                }
            });
        }

        // --- Initial Setup ---
        // Attach listeners to the first pricelist item
        attachPricelistListeners(document.getElementById('pricelist-item-0'));
        updateButtonVisibility(); // Set initial visibility for buttons


        // Handle Preview Button Click
        addToPreviewButton.addEventListener('click', function () {
            // Get HPS Header Data
            const hpsHeaderData = {
                'Nama Cargo': document.getElementById('cargo_name').value,
                'Consignee': document.getElementById('consignee').value,
                'Vessel Name': document.getElementById('vessel_name').value,
                'Tonase': document.getElementById('tonase').value,
                'Jumlah Gang': document.getElementById('jumlah_gang').value,
                'L/D Rate': document.getElementById('ldrate').value,
                'Hari': document.getElementById('hari').value,
                'Shift': document.getElementById('shift').value,
                'Jam': document.getElementById('jam').value,
            };

            // Get all Pricelist Data
            const allPricelistItems = document.querySelectorAll('.pricelist-item');
            const pricelistDataArray = [];
            allPricelistItems.forEach((itemElement, index) => {
                const serviceSelect = itemElement.querySelector('.service-select');
                pricelistDataArray.push({
                    'Service': serviceSelect ? serviceSelect.options[serviceSelect.selectedIndex].text : 'N/A',
                    'Nama': itemElement.querySelector('[name*="[nama]"]').value,
                    'Quantity': itemElement.querySelector('[name*="[qty]"]').value,
                    'Jumlah Pemakaian': itemElement.querySelector('[name*="[jml_pemakaian]"]').value,
                    'Tarif (Price)': itemElement.querySelector('[name*="[price]"]').value,
                    'Satuan': itemElement.querySelector('[name*="[satuan]"]').value,
                    'Total': itemElement.querySelector('[name*="[total]"]').value,
                });
            });

            // Populate Preview Section
            previewBody.innerHTML = '';

            previewBody.innerHTML += `<tr><td colspan="2"><strong>HPS Header:</strong></td></tr>`;
            for (const key in hpsHeaderData) {
                previewBody.innerHTML += `<tr><td>${key}:</td><td>${hpsHeaderData[key]}</td></tr>`;
            }

            if (pricelistDataArray.length > 0) {
                previewBody.innerHTML += `<tr><td colspan="2"><strong>Pricelist Items:</strong></td></tr>`;
                pricelistDataArray.forEach((item, index) => {
                    previewBody.innerHTML += `<tr><td colspan="2"><em>Pricelist Item #${index + 1}:</em></td></tr>`;
                    for (const key in item) {
                        previewBody.innerHTML += `<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;${key}:</td><td>${item[key]}</td></tr>`;
                    }
                });
            }

            previewSection.style.display = 'block';
        });


        saveButton.addEventListener('click', function () {
            const combinedForm = document.createElement('form');
            combinedForm.method = 'POST';
            combinedForm.action = '{{ route('hps.store') }}';
            combinedForm.style.display = 'none';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            combinedForm.appendChild(csrfToken);

            // Append HPS Header inputs
            const hpsHeaderForm = document.getElementById('hpsHeaderForm');
            Array.from(hpsHeaderForm.elements).forEach(element => {
                if (element.name && element.type !== 'submit') {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = element.name;
                    input.value = element.value;
                    combinedForm.appendChild(input);
                }
            });

            // Append Pricelist inputs (all dynamic items)
            const allPricelistItems = document.querySelectorAll('.pricelist-item');
            allPricelistItems.forEach(itemElement => {
                // For each pricelist item, we need to gather its specific inputs
                Array.from(itemElement.querySelectorAll('input, select')).forEach(element => {
                    if (element.name && element.type !== 'submit') {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = element.name; // This name already has the correct array format (e.g., pricelists[0][service_id])
                        input.value = element.value;
                        combinedForm.appendChild(input);
                    }
                });
            });

            document.body.appendChild(combinedForm);
            combinedForm.submit();
        });
    });
</script>
@endsection