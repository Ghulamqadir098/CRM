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
    <form action="{{ route('serviceweb.update', $serviceweb) }}" method="POST" enctype="multipart/form-data" class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
        @method('PUT')
        @csrf
        <h6 class="mb-5 text-lg font-bold">Edit Service</h6>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Row 1 -->
            <div>
                <label for="name">Title*</label>
                <input id="name" name="name" type="text" value="{{ $serviceweb->name }}" placeholder="Service title" class="form-input" required>
                @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="price">Price*</label>
                <input id="price" name="price" type="number" min="1" value="{{ $serviceweb->price }}" placeholder="Service price" class="form-input" required>
                @error('price')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 2 -->
            <div>
                <label for="duration">Duration (Days)*</label>
                <input id="duration" name="duration" type="number" min="1" value="{{ $serviceweb->duration }}" placeholder="Duration in days" class="form-input" required>
                @error('duration')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 3 (full width) -->
            <div class="md:col-span-2">
                <label for="image">Service Image</label>
                <div class="mb-3">
                    <img src="{{ $serviceweb->image }}" alt="Current service image" class="h-32 object-cover rounded-md">
                </div>
                <input type="file" name="image" id="image" class="form-input" accept="image/*">
                @error('image')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Row 4 (full width) -->
            <div class="md:col-span-2">
                <label for="description">Description*</label>
                <textarea id="editor" name="description" rows="4" class="form-textarea" placeholder="Service description">{{ $serviceweb->description }}</textarea>
                @error('description')
                    <span class="text-danger text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button class="mr-3">
                <a href="{{ route('serviceweb.index') }}" class="btn btn-md btn-danger">Cancel</a>
            </button>
            <button type="submit" class="btn btn-primary z-50">Update</button>
            
        </div>
    </form>
</div>

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