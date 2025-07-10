@extends('layouts.master')

@section('content')
<div class="container">
    
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <form action="{{ route('hps.store') }}" method="POST" id="mainHpsForm">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h2 class="mb-0">HPS Header</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cargo_name" class="form-label">Nama Cargo</label>
                        <input type="text" name="cargo_name" id="cargo_name" class="form-control form-control-sm" value="{{ old('cargo_name') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="consignee" class="form-label">Consignee</label>
                        <input type="text" name="consignee" id="consignee" class="form-control form-control-sm" value="{{ old('consignee') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="vessel_name" class="form-label">Vessel Name</label>
                        <input type="text" name="vessel_name" id="vessel_name" class="form-control form-control-sm" value="{{ old('vessel_name') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tonase" class="form-label">Tonase</label>
                        <input type="number" name="tonase" id="tonase" class="form-control form-control-sm" value="{{ old('tonase') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jumlah_gang" class="form-label">Jumlah Gang</label>
                        <input type="number" name="jumlah_gang" id="jumlah_gang" class="form-control form-control-sm" value="{{ old('jumlah_gang') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="ldrate" class="form-label">L/D Rate</label>
                        <input type="number" name="ldrate" id="ldrate" class="form-control form-control-sm" value="{{ old('ldrate') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="hari" class="form-label">Hari</label>
                        <input type="number" name="hari" id="hari" class="form-control form-control-sm" value="{{ old('hari') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="shift" class="form-label">Shift</label>
                        <input type="number" name="shift" id="shift" class="form-control form-control-sm" value="{{ old('shift') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="number" name="jam" id="jam" class="form-control form-control-sm" value="{{ old('jam') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h2 class="mb-0">Pricelist</h2>
            </div>
            <div class="card-body">
                <div id="pricelistContainer">
                    <div class="row align-items-end mb-3 pricelist-item" id="pricelist-item-0">
                        <div class="col-md-2 mb-3">
                            <label for="service_id_0" class="form-label">Jasa</label>
                            <select name="pricelists[0][service_id]" id="service_id_0" class="form-control form-control-sm service-select" required>
                                <option value="">Pilih Jasa</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" data-nama="{{ $service->nama }}">{{ $service->nama }}</option>
                                @endforeach
                            </select>
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
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <div class="flex-grow-1 me-1">
                                <label for="total_0" class="form-label">Total</label>
                                <input type="number" name="pricelists[0][total]" id="total_0" class="form-control form-control-sm total-input" readonly>
                            </div>
                            <div class="d-flex flex-column">
                                <button type="button" class="btn btn-success btn-sm mb-1 add-pricelist-item">+</button>
                                <button type="button" class="btn btn-danger btn-sm remove-pricelist-item" style="display: none;">-</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pricelistContainer = document.getElementById('pricelistContainer');
        let pricelistItemCount = 0; 

        function calculatePriceAndTotal(itemElement) {
            const serviceSelect = itemElement.querySelector('.service-select');
            const qtyInput = itemElement.querySelector('.qty-input');
            const jmlPemakaianInput = itemElement.querySelector('.jml-pemakaian-input');
            const priceInput = itemElement.querySelector('.price-input');
            const totalInput = itemElement.querySelector('.total-input');
            const namaInput = itemElement.querySelector('.pricelist-nama-input');

            if (!serviceSelect || serviceSelect.selectedIndex === -1 || !serviceSelect.options[serviceSelect.selectedIndex]) {
                priceInput.value = (0).toFixed(2);
                totalInput.value = (0).toFixed(2);
                if (namaInput) namaInput.value = ''; 
                return;
            }

            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const harga = parseFloat(selectedOption.dataset.harga || 0) || 0;
            const serviceName = selectedOption.dataset.nama || ''; 

            const qty = parseFloat(qtyInput.value || 0) || 0;
            const jmlPemakaian = parseFloat(jmlPemakaianInput.value || 0) || 0;

            priceInput.value = harga.toFixed(2);
            totalInput.value = (harga * qty * jmlPemakaian).toFixed(2);
            if (namaInput) namaInput.value = serviceName; 
        }

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
                    updateButtonVisibility();
                });
            }

            calculatePriceAndTotal(itemElement); 
        }

        function addNewPricelistItem() {
            const lastPricelistItem = pricelistContainer.lastElementChild;
            pricelistItemCount++;

            const newItem = lastPricelistItem.cloneNode(true);

            newItem.id = `pricelist-item-${pricelistItemCount}`;

            
            newItem.querySelectorAll('[id]').forEach(element => {
                const oldId = element.id;
                const newId = oldId.replace(/_\d+$/, `_${pricelistItemCount}`);
                element.id = newId;

                const label = document.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newId);
                }
            });

           
            newItem.querySelectorAll('[name]').forEach(element => {
                const oldName = element.name;
                const newName = oldName.replace(/pricelists\[\d+\]/, `pricelists[${pricelistItemCount}]`);
                element.name = newName;
            });

            
            newItem.querySelectorAll('input').forEach(input => {
                
                if (input.classList.contains('qty-input') || input.classList.contains('jml-pemakaian-input')) {
                    input.value = '1';
                } else {
                    input.value = '';
                }
            });
            newItem.querySelector('.service-select').selectedIndex = 0;

            pricelistContainer.appendChild(newItem);
            attachPricelistListeners(newItem);
            updateButtonVisibility();
        }

        function updateButtonVisibility() {
            const allPricelistItems = document.querySelectorAll('.pricelist-item');

            allPricelistItems.forEach((item, index) => {
                const addButton = item.querySelector('.add-pricelist-item');
                const removeButton = item.querySelector('.remove-pricelist-item');

                if (index === allPricelistItems.length - 1) {
                    addButton.style.display = 'block';
                } else {
                    addButton.style.display = 'none'; 
                }

                if (allPricelistItems.length > 1) {
                    removeButton.style.display = 'block'; 
                } else {
                    removeButton.style.display = 'none';
                }
            });
        }
        attachPricelistListeners(document.getElementById('pricelist-item-0'));
        updateButtonVisibility();
    });
</script>
@endsection