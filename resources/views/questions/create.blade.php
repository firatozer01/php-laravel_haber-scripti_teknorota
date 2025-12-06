@extends('layouts.site')

@section('title', 'Soru Sor - News Wrap')

@section('content')
<!-- Include Summernote CSS/JS via CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
    /* Dark Mode Overrides for Summernote */
    .dark .note-editor .note-toolbar {
        background-color: #222 !important;
        border-bottom: 1px solid #444 !important;
        color: #fff !important;
    }
    .dark .note-editor .note-editing-area .note-editable {
        background-color: #111 !important;
        color: #ddd !important;
    }
    .dark .note-editor .note-statusbar {
        background-color: #222 !important;
    }
    .dark .note-btn {
        color: #ddd !important;
        background-color: #333 !important;
        border: 1px solid #444 !important;
    }
    .dark .note-btn:hover {
        background-color: #444 !important;
    }
</style>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-black uppercase tracking-tighter mb-8">Soru Sor</h1>

    <form action="{{ route('questions.store') }}" method="POST" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 p-8 rounded-xl shadow-lg">
        @csrf
        
        <div class="mb-6">
            <label class="block font-bold uppercase text-xs mb-2">Başlık</label>
            <input type="text" name="title" class="w-full bg-gray-50 dark:bg-black border border-gray-300 dark:border-gray-700 p-4 focus:ring-2 focus:ring-black dark:focus:ring-white outline-none transition rounded-lg text-black dark:text-white" placeholder="Sorunuzun başlığı..." required>
        </div>

        <div class="mb-8">
            <label class="block font-bold uppercase text-xs mb-2">Detaylar</label>
            <textarea id="summernote" name="content" required></textarea>
        </div>

        <button type="submit" class="w-full px-6 py-4 bg-black text-white dark:bg-white dark:text-black font-bold uppercase tracking-wider hover:opacity-80 transition rounded-lg text-lg">Gönder</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Sorunuzu detaylandırın... Görsel ekleyebilir, yazı biçimlendirebilirsiniz.',
            tabsize: 2,
            height: 300,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                }
            }
        });

        function uploadImage(file) {
            let data = new FormData();
            data.append("image", file);
            
            // USE CSRF TOKEN FROM META or INPUT
            // Here we assume it's injected by Blade
            data.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('questions.upload.image') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    if(response.success) {
                        $('#summernote').summernote('insertImage', response.url);
                    } else {
                        alert('Resim yüklenemedi: ' + response.error);
                    }
                },
                error: function(data) {
                    console.error("Upload Error:", data);
                    alert("Görsel yüklenirken sunucu hatası oluştu.");
                }
            });
        }
    });
</script>
@endsection
