@php
    $shouldDisplay = $errors->any() && (!isset($formContext) || old('form_context') === $formContext);
@endphp

@if ($shouldDisplay)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Periksa kembali input Anda.</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
