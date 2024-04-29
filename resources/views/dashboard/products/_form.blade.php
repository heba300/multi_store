<div class="form-group">

    <x-form.input name='name' :value="$product->name" label='Product Name' class="form-control-lg" role="input" />
</div>

<div class="form-group mb-3">
    <label for="category_id">Category</label>
    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
        <option value="">Select One</option>
        @foreach (\App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @if ($category->id == old('category_id', $product->category_id)) selected @endif>{{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <x-form.input name="description" label='Description' :value="$product->description" />
</div>


<div class="form-group">
    <x-form.label> Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    {{-- @if ($product->image)
        <img src="{{ asset('storage/' . $category->image) }}" height="60" alt="">
    @endif --}}
</div>

<div class="form-group">
    <x-form.input name="price" label='Price' :value="$product->price" />
</div>
<div class="form-group">
    <x-form.input name="compare_price" label='compare price' :value="$product->compare_price" />
</div>
<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags" />
</div>

<div class="form-group">
    <label for="">Status</label>
    <div>
        <x-form.radio name='stutas' :checked="$product->stutas" :option="['active' => 'Active', 'draft' => 'draft', 'archvied' => 'archvied']" />

    </div>

</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'save' }}</button>
</div>

@push('styles')
    <link href="{{ asset('dist/css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('dist/js/tagify.polyfills.min.js') }}"></script>
    <script src="{{ asset('dist/js/tagify.js') }}"></script>

    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endpush
