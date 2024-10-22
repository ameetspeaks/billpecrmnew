@component('admin.component')
@slot('title') Homepage Video  @endslot
@slot('subTitle')Homepage Video list@endslot
@slot('content')
<div class="text-right col-12">
    @can('Create Role')
    <a href="{{ route('admin.homepagevideo.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Homepage Video</button>
    </a>
    @endcan
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Homepage Image/Video </th>
                <th> Package Type </th>
                <th> Module Condition </th>
                <th> Status </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>
</div>
@endslot
@slot('script')
<script type="text/javascript">
    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              order: [],
              ajax: "{{ route('admin.homepagevideo.index') }}",
          
                "columns": [
                    {
                        "data": "homepage_video_image",
                        "render": function(data, type, row) {
                            var fileExtension = row.homepage_video_image.substr((row.homepage_video_image.lastIndexOf('.') + 1));
                            console.log(fileExtension)
                            if(fileExtension == 'mp4'){
                                // return ' <iframe class="embed-responsive-item" src="'+row.homepage_video_image+'"></iframe>';
                                return '<video width="250px" height="400px"controls="controls"><source src="'+row.homepage_video_image+'" type="video/mp4" /></video>';
                            }else{
                                return ' <img src="'+row.homepage_video_image+'" alt="Image"> ' ;
                            }
                        },
                    },
                    {
                        "data": "package_type",
                    },
                    {
                        "data": "module_condition",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.module_condition == 0){
                                return ' <span>First Time</span> ' ;
                            }else{
                                return ' <span>Marketing</span> ' ;
                            }
                        },
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.status == 1){
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="homepage_video" checked> <span class="slider round"></span> </label> ' ;
                            }else{
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="homepage_video"> <span class="slider round"></span> </label> ' ;
                            }
                        },
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" {{ url('admin/editHomepageVideo') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li> </ul>';

                        },
                    },
                ],

          });
        });

        $(document).on('click', '#remove', function(){
            var id = $(this).attr('data-id');
            
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                if(result.value){

                    var url = '{{ route('admin.homepagevideo.delete',["id" => ":id"]) }}';
                    url = url.replace(':id', id);
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data)
                        {
                            if(data.status == false){
                                Swal.fire(data.title,data.message,data.type);
                            }
                            Swal.fire(
                                "Deleted!",
                                "Deleted successfully.",
                                "success"
                            ).then(function() {
                                $('.table').DataTable().ajax.reload();
                            });
                        }
                    });

                }
            });
        })

        //change status
        $(document).on('click','.changeStatus', function(){
            var id = $(this).attr('data-id');
            var statusName = $(this).attr('data-statusName');
            
            $.ajax({
                    url: "{{ route('admin.centralLibrary.changeStatus') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'id': id , 'statusName': statusName},
                    success: function(data){
                    console.log(data)
                    $('.table').DataTable().ajax.reload();
                    }
            });

        })
</script>
@endslot
@endcomponent

