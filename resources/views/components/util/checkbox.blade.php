<div class="form-check">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" @if(isset($value)) value="{{ $value }}" @endif id="{{ isset($id) ? $id : str_replace('[]', '', $name).'Checkbox' }}" {{ isset($checked) && ($checked == "true" || $checked == 1) ? 'checked' : ''}}>
    <label class="form-check-label" for="{{ isset($id) ? $id : str_replace('[]', '', $name).'Checkbox' }}">{{ $slot }}</label>
</div>
