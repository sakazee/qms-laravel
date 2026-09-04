@if($errors->any())
<div x-data="{ show: true }" x-show="show" x-transition class="alert alert-error">
    <div class="flex items-start gap-3">
        <i class="fa-solid fa-circle-exclamation mt-1 text-rose-500"></i>
        <div class="flex-1">
            <div class="font-bold">{{ app()->getLocale() === 'bn' ? 'ত্রুটি পাওয়া গেছে' : 'Validation Errors' }}</div>
            <ul class="mt-1 list-inside list-disc space-y-0.5 pl-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" @click="show = false" class="text-rose-300 hover:text-rose-500">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@endif