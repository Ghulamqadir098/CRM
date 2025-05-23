@extends('layouts.layout')

@section('content')
<!-- input text -->
<ol class="ms-3 mt-5 flex text-gray-500 font-semibold dark:text-white-dark">
    <li><a href="{{ route('dashboardweb') }}">Dashboard</a></li>
    <li class="before:content-['/'] before:px-1.5"><a
            class="text-black dark:text-white-light hover:text-black/70 dark:hover:text-white-light/70">Products</a>
    </li>
</ol>

<div class="my-auto">
    <form action="{{ route('productweb.update', $productweb->id) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @method('PUT')
        @csrf
        <h6 class="mb-5 text-lg font-bold">Edit Product</h6>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Row 1 -->
            <div>
                <label for="name">Title*</label>
                <input id="name" name="name" type="text" value="{{ $productweb->name }}" placeholder="Product title" class="form-input" >
                @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="category">Category*</label>
                <input id="category" name="category" type="text" value="{{ $productweb->category }}" placeholder="Product category" class="form-input" >
                @error('category')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 2 -->
            <div>
                <label for="price">Price*</label>
                <input id="price" name="price" type="number" min="1" value="{{ $productweb->price }}" placeholder="Product price" class="form-input" >
                @error('price')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="stock_quantity">Stock Quantity*</label>
                <input id="stock_quantity" name="stock_quantity" type="number" min="1" value="{{ $productweb->stock_quantity }}" placeholder="Available quantity" class="form-input" >
                @error('stock_quantity')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 3 (full width) -->
            <div class="md:col-span-2">
                <label for="image">Product Image</label>
                <div class="mb-3">
                    <img src="{{ $productweb->image }}" alt="Current product image" class="h-32 object-cover rounded-md">
                </div>
                <input type="file" name="image" id="image" class="form-input" accept="image/*">
                @error('image')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 4 (full width) -->
            <div class="md:col-span-2">
                <label for="description">Description*</label>
                <textarea id="editor" name="description" rows="4" class="form-textarea" placeholder="Product description">{{ $productweb->description }}</textarea>
                @error('description')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button class="mr-3">
                <a href="{{ route('productweb.index') }}" class="btn btn-md btn-danger">Cancel</a>
            </button>
            <button type="submit" class="btn btn-primary z-50">Update</button>
           
        </div>
    </form>
</div>
{{-- <div class="w-full self-center mx-auto mt-10">
    <h2 class="text-lg font-medium">Edit Product</h2>
    <form action="{{ route('productweb.update', $productweb->id) }}" enctype="multipart/form-data" method="POST" class="mt-6 flex">
        <div class="bg-red-500 p-5 w-3/5 mx-3 my-5 border-2 rounded-md border-solid">
            <h3 class="text-lg font-medium text-center">Title and Description</h3>
        @method('PUT')
        @csrf
        <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="name" placeholder="Some Text..." class="form-input" value="{{ $productweb->name }}" required />
        @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            
        @enderror
        <label for="description" class="block text-sm font-medium text-gray-700 mt-4">Description</label>
        <textarea name="description" id="editor" cols="30" rows="10" class="form-textarea" placeholder="Some Text...">{{$productweb->description}}</textarea>
       @error('description')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
           
       @enderror
        </div>
        <div class="bg-red-500 p-5 w-1/3 mx-3 my-5 border-2 rounded-md border-solid">
            <h3 class="text-lg font-medium text-center">Price and Stock info</h3>
        <label for="Image" class="block text-sm font-medium text-gray-700 mt-4">Image</label>
        <img src="{{$productweb->image }}" alt="" class="w-1/2">
        <input type="file" name="image" id="image" class="form-input" accept="image/*" value="{{ old('image') }}" />
        @error('image')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            
        @enderror
        <label for="price" class="block text-sm font-medium text-gray-700 mt-4">Price</label>
        <input type="number" min="1" name="price" placeholder="Some Text..." class="form-input" value="{{ $productweb->price }}" required />
        @error('price')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            
        @enderror
        <label for="category" class="block text-sm font-medium text-gray-700 mt-4">Category</label>
        <input type="text" name="category" placeholder="Some Text..." class="form-input" value="{{ $productweb->category }}" required />
        @error('category')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mt-4">Stock Quantity</label>
        <input type="number" min="1" name="stock_quantity" placeholder="Some Text..." class="form-input" value="{{  $productweb->stock_quantity }}" required />
        @error('stock_quantity')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn w-full btn-primary mt-6">Update</button>
        </div>
    </form>
</div> --}}

@endsection


@section('scripts')
<script src="https://cdn.tiny.cloud/1/9jcnevrrp0wzd0ejs2j5wv77ic4anl0pi2qdv0ox72zawhw0/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#editor',
        plugins: 'link lists',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',

        menubar: false,
        height: 300
    });
</script>
@endsection