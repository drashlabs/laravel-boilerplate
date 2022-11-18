{{--@extends('ui.layouts.app', ['title' => 'Dashboard'])--}}

{{--@section('content')--}}


{{--    @if(Auth::user()->role == "")--}}

{{--        <h3>Listings page</h3>--}}
{{--        --}}

{{--    @endif--}}


{{--@endsection--}}

@extends('ui.layouts.app', ['title' => 'Listings'])

@section('content')
    @if(Auth::user()->role == "")
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h1 class="float-left">Listings</h1>
                            <a href="{{ route('listings.create') }}" class="float-right btn btn-primary btn-sm">
                                <i class="fas fa-fw fa-plus"></i> listing
                            </a>
                        </div>
                        <table id="users" class="table table-borderless table-hover dt-responsive nowrap">
                            <thead>
                               <tr>
                                   <th>Name</th>
                                   <th>Location</th>
                                   <th>Price</th>
                               </tr>
                            </thead>
                            @foreach($listings as $listing)
                            <tbody>

                                    <td>{{$listing->name}}</td>
                                    <td>{{$listing->location}}</td>
                                    <td>{{$listing->price}}</td>

                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#users').DataTable(   {
                {{--ajax: "{{ route('users.index') }}",--}}
                {{--columns: [--}}
                {{--    {data: 'name'},--}}
                {{--    {data: 'email'}--}}
                {{--],--}}
                fnDrawCallback: function (settings) {
                    $(settings.nTHead).hide();
                }
            });
        });
    </script>
@endpush

