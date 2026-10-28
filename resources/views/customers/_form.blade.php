@csrf
<label for="name">Full name</label>
<input id="name" type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" maxlength="50" required>
@error('name') <p class="field-error">{{ $message }}</p> @enderror

<label for="phone">Phone number</label>
<input id="phone" type="text" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" placeholder="0812 3456 7890" required>
@error('phone') <p class="field-error">{{ $message }}</p> @enderror

<label for="address">Address (optional)</label>
<input id="address" type="text" name="address" value="{{ old('address', $customer->address ?? '') }}" maxlength="120">
@error('address') <p class="field-error">{{ $message }}</p> @enderror
