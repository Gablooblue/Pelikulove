@if($submission->updated_at->gt($submission->created_at))
 	<div class="small mb-2">Note: The owner uploaded the most recent file last {{ \Carbon\Carbon::parse($submission->updated_at)->format('j M Y h:i A')  }}.</div>
	@endif

	
    @if ($submission->file != ""  && strpos($submission->file, ".pdf") !== false)
    <div class="embed-responsive embed-responsive-16by9">
    <object data="{{url($url)}}#view=fit&toolbar=0&navpanes=0" type="application/pdf">
    <iframe class="embed-responsive-item" src="{{url($url)}}#view=fit&toolbar=0&navpanes=0" style="border: none;" frameborder=0 allowtransparency="true">
    </iframe>
    </object>
    </div>
	@elseif  ($submission->file != ""  && (strpos($submission->file, ".doc") !== false || strpos($submission->file, ".docx") !== false) )
	<div class="embed-responsive embed-responsive-16by9">
        <iframe  class="embed-responsive-item" src="https://docs.google.com/gview?url={{url($url)}}&embedded=true"></iframe>
	</div>
    @elseif  ($submission->file != ""  && strpos($submission->file, ".pdf") !== true)
    <div class="">@php $size = getImageSize($path); @endphp
    	<img class="img-fluid" @if($size)width="{{$size[0]}}px" height="{{$size[1]}}px"@endif src="{{url($url)}}">
    </div>  
    @endif
     
        
