@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Github User Tester') }}</div>

                    <div class="card-body">
                        <form method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="xVal">Users</label>
                                <input type="text" class="form-control" id="users" name="users" value="" aria-describedby="xVal" placeholder="Users seperated by comma">

                            </div>
                            <div class="form-group">
                                <label for="">API</label>
                                <div></div>
                            </div>
                            <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                            <div class="form-group">
                                <label for="">Result</label>
                                <pre id="request_result"></pre>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#submit-btn').click(function (e){
            e.preventDefault();

            $.ajax({
                url: SITE_URL +'/api/github/users/' + $('#users').val(),
                type: 'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer {{auth()->user()->tokens->first()->token}}');
                },
                data: {},
                success: function (response) {
                    console.log(response)
                    $('#request_result').html(JSON.stringify(response,undefined,2));
                },
                error: function (response) {
                    console.log(response)
                    $('#request_result').html(JSON.stringify(response,undefined,2));
                },
            });
        });
    </script>
@endpush
