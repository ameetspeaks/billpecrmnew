<!-- Your Blade View Code -->
@component('admin.component')
@slot('title') User Trial Package Detail @endslot
@slot('subTitle') Package Details @endslot
@slot('content')

    <div class="table-responsive mt-3">
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- <th> SL </th> -->
                    <th> Store Name </th>
                    <th> Phone</th>
                    <th> Address</th>
                    <th> Package Name </th>
                    <th> Start Date  </th>
                    <th> End Date</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop through your data here --}}
            </tbody>
        </table>
    </div>
@endslot
@slot('script')
<script>
    $(function () {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.viewTrialTable') }}",
            
        });
    });

</script>



@endslot
@endcomponent
