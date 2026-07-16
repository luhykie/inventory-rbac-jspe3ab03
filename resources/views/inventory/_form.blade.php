<div class="form-group">
    <label for="name">Item Name</label>
    <input type="text" id="name" name="name" value="{{ old('name', $item->name ?? '') }}" required>
    @error('name') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="sku">SKU</label>
    <input type="text" id="sku" name="sku" value="{{ old('sku', $item->sku ?? '') }}" required>
    @error('sku') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="3">{{ old('description', $item->description ?? '') }}</textarea>
    @error('description') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity', $item->quantity ?? 0) }}" required>
    @error('quantity') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="form-group">
    <label for="unit_price">Unit Price (PHP)</label>
    <input type="number" id="unit_price" name="unit_price" min="0" step="0.01" value="{{ old('unit_price', $item->unit_price ?? '0.00') }}" required>
    @error('unit_price') <p class="error">{{ $message }}</p> @enderror
</div>
