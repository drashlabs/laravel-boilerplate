@extends('ui.layouts.profile', ['title' => 'Create new listing'])

@section('view')
    <form class="bg-white p-4" method="POST" action="{{ route('listings.store') }}" novalidate>
        @csrf
        <div class="form-group">
            <label for="name" class="sr-only">Name/Description</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   required
                   placeholder="Name/Description"
                   autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="location" class="sr-only">Location</label>
            <input type="text"
                   id="location"
                   name="location"
                   class="form-control @error('location') is-invalid @enderror"
                   value="{{ old('location') }}"
                   required
                   placeholder="Location">
            @error('location')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="price" class="sr-only">price</label>
            <input type="price"
                   id="price"
                   name="price"
                   class="form-control @error('price') is-invalid @enderror"
                   value="{{ old('price') }}"
                   required
                   placeholder="price">
            @error('price')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
{{--        <div class="px-2">--}}
{{--            <label for="price"></label>--}}
{{--            <input type="number" name="price" id="price">--}}
{{--            @foreach ($roles as $role)--}}
{{--                <div class="form-check">--}}
{{--                    <label class="form-check-label">--}}
{{--                        <input type="checkbox"--}}
{{--                               id="role-{{ $role->uuid }}"--}}
{{--                               name="roles[]"--}}
{{--                               value="{{ $role->id }}"--}}
{{--                               class="form-check-input" {{ (old('roles') && in_array($role->id, old('roles'))) ? 'checked' : null }}>--}}
{{--                        {{ $role->name }}--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
        <button type="submit" class="btn btn-block btn-primary">
            Create listing
        </button>
    </form>
@endsection
