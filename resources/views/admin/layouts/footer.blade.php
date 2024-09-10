<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-center text-sm-left d-block d-sm-inline-block">
        
         <a href="{{route('admin.dashboard')}}" target="_blank">{{\App\Models\Setting::where('type','company_address')->first()->value ?? ''}}</a> 
        </span> 

        <span class="text-center text-sm-left d-block d-sm-inline-block">
            <a href="{{route('admin.dashboard')}}" target="_blank">{{\App\Models\Setting::where('type','company_footer_text')->first()->value ?? ''}}</a> 
        </span> 
    </div>
</footer>
