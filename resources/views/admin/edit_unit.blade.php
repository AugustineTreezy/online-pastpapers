@extends('layouts.app')

@section('title')
    <title>Units - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-clone"></i> Edit Unit</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Units</a></li>
            <li class="breadcrumb-item"><a href="{{ route('units.destroy', ['slug'=>$unit->slug]) }}">{{$unit->slug}}</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">  
                <form method="POST" autocomplete="off" action="{{ route('units.update', ['slug'=>$unit->slug]) }}" enctype="multipart/form-data">
                    @csrf      
                    <input type="hidden" name="_method" value="PUT">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="department" class="{{ $errors->has('department') ? ' text-danger' : '' }}">Department</label>
                            <select class="form-control{{ $errors->has('department') ? ' is-invalid' : '' }}" id="department" name="department" required>
                                <option value="">-- Study level where the pastpaper belongs --</option>
                                @foreach ($departments as $single_department)
                                <option value="{{$single_department->slug}}" @if ($single_department->slug == $unit->department->slug) selected @endif>{{$single_department->name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('department') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>               
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="name" class="{{ $errors->has('name') ? ' text-danger' : '' }}">Unit Name</label>
                            <input type="text" id="name" value="{{$unit->name}}" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Unit Name" required>  
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif          
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="code" class="{{ $errors->has('code') ? ' text-danger' : '' }}">Unit Code</label>
                            <input type="text" name="code" value="{{$unit->code}}" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" autocomplete="new-text" placeholder="Unit Code" required>  
                            @if ($errors->has('code'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif          
                        </div>
                    </div>
                    <div class="tile-footer">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Update</button>  
                    </div>                     
                </form> 
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>    
<script>
    $(document).ready(function() {
        $('#department').select2();
    });
</script>
@endsection