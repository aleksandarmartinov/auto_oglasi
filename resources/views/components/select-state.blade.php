<select id="stateSelect" name="state_id">
    <option value="">Država/Region</option>
    @foreach($states as $state)
        <option value="{{ $state->id }}"
            @selected($attributes->get('value') == $state->id)>{{ $state->name }}</option>
    @endforeach
</select>
