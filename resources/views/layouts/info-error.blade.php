@if (session()->has('info'))
    <div class="alert {{ session('color') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ session('info') }}
    </div>    
@endif  
@if (session()->has('errors'))
    <div class="alert bg-red alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        @foreach($errors->all() as $message)
            {{$message}}<br>
        @endforeach
    </div>    
@endif   

 