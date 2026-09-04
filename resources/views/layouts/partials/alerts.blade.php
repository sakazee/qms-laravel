@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h6><i class="icon fas fa-ban"></i> {{ app()->getLocale() === 'bn' ? 'ত্রুটি পাওয়া গেছে:' : 'Validation Errors:' }}</h6>
    <ul class="mb-0 pl-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
