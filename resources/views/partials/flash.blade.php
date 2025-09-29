@if(session('success') || session('error') || $errors->any())
<div class="mb-3" aria-live="polite" aria-atomic="true">
    @if(session('success'))
    <div class="alert alert-success alert-role" role="alert" tabindex="-1">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-role" role="alert" tabindex="-1">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-role" role="alert" tabindex="-1">
        <strong>There were validation errors:</strong>
        <ul class="mb-0 small">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const a = document.querySelector('.alert-role');
        if (a) {
            a.focus({
                preventScroll: false
            });
        }
    });
</script>
@endif