@props(['class_type','msg_text'])
<!-- Alert Box -->
<!-- <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Success!</strong> Hello, world! 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div> -->

<div class="toast show text-white bg-{{ $class_type }} toast-custom-box" >
    <div class="toast-header">
        <strong class="mr-auto text-{{ $class_type }}">{{ $msg_text }}</strong>
    </div>
</div>
