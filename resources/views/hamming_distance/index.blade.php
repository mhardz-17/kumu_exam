@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Hamming Distance Calculator') }}</div>

                    <div class="card-body">
                        <form method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="xVal">X Input</label>
                                <input type="number" class="form-control" id="xVal" name="xVal" value="{{ old('xVal') }}" aria-describedby="xVal" placeholder="X Value">
                                @error('xVal')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="yVal">Y Input</label>
                                <input type="number" class="form-control" id="yVal" name="yVal" value="{{ old('yVal') }}" placeholder="Y Value">
                                @error('yVal')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="answer">XVal Bin : <strong>{{$xValBin ?? '' }}</strong></label>
                                <br>
                                <label for="answer">YVal Bin : <strong>{{$yValBin ?? '' }}</strong></label>
                                <br>
                                <label for="answer">Answer : <strong>{{$answer ?? '' }}</strong></label>
                            </div>
                            <button type="submit" class="btn btn-primary">Compute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
