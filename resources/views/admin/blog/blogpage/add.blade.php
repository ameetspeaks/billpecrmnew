@component('admin.component')
@slot('title') Add blog @endslot

@slot('subTitle') add blog detail @endslot
@slot('content')

<form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">                   
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

        <div>
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none" required>
                <option value="">select</option>
                @foreach ($categoties as $item)
                    <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>{{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                placeholder="Enter post title"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none" required>
        </div>

        <div>
            <label for="image">Featured image</label>
            <input type="file" name="image" id="image"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none" required>
        </div>


        <div class="md:col-start-1 md:col-end-4">
            <label for="meta_title">Meta title</label>
            <input name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none"
                required />
        </div>
        <div class="md:col-start-1 md:col-end-4">
            <label for="meta_desc">Meta Description</label>
            <input name="meta_desc" id="meta_desc" value="{{ old('meta_desc') }}"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none"
                required />
        </div>
        <div class="md:col-start-1 md:col-end-4">
            <label for="meta_keywords">Meta Keywords</label>
            <input name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none"
                required />
        </div>

        <div class="md:col-start-1 md:col-end-4">
            <label for="summernote">Full Post</label>
            <textarea name="post" id="summernote" placeholder="Write post here..."
                class="w-full border border-gray-400 p-1 bg-white rounded focus:outline-none">{{ old('post') }}</textarea>
        </div>

        <div class="">
            <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
            <a href="{{ route('admin.blog.index') }}"><div class="btn btn-light">Cancel</div></a>
        </div>
    </div>

</form>

@endslot
@slot('script')
<script>
    $('#summernote').summernote({
        placeholder: 'Show your writing creativity here...',
        tabsize: 2,
        height: 300,
        callbacks: {
            onImageUpload: function(files) {
                // upload image to server and create imgNode...
                for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                }
            },
            onImageUploadError: function() {
                console.log('error');
            },
            onMediaDelete: function(target) {
                deleteImage(target[0].src)
            }
        }
    });

    const insertImage = (url) => {
        let imgNode = $('<img>').attr('src', url)
        $('#summernote').summernote('insertNode', imgNode[0]);
    }

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        const uploadImage = (file) => {
            let form = new FormData();
            form.append('image', file);

            $.ajax({
                method: 'POST',
                url: "{{ route('admin.blog.image.upload') }}",
                contentType: false,
                cache: false,
                processData: false,
                data: form,
                beforeSend: () => {
                    // console.log('beforeSend');
                },
                success: function(result) {
                    console.log(result);
                    insertImage(result.url)
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }

        const deleteImage = (url) => {
            let form = new FormData();
            form.append('url', url);

            $.ajax({
                method: 'POST',
                url: "{{ route('admin.blog.image.delete') }}",
                contentType: false,
                cache: false,
                processData: false,
                data: form,
                beforeSend: () => {
                    // console.log('beforeSend');
                },
                success: function(result) {
                    toast.info(result.msg)
                },
                error: function(error) {
                    console.log("error", error);
                }
            });
        }
</script>
@endslot
@endcomponent

