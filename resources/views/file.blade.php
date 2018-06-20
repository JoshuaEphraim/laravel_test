<!doctype html>
@extends('layouts.main')
@section('header')
    @parent
@stop
@section('content')
    <div id="wrapper"><div class="inner">

            <div class="header">
                <p class="caption">File Base</p>
                <p><label>Paste url:<input class="input_file" type="text" name="url"/></label></p>
            </div>


            <div class="errors">
                <ul>

                </ul>
            </div>

        </div></div>
    <div id="second"><div class="inner">

            {{--<div class="column config">
                <p class="caption">Select country</p>
                <div class="list-group countries">
                    <a href="index.php?connect=directory" class="list-group-item active">All</a>
                </div>
                <p class="caption">Select rate</p>
                <div class="list-group rate">
                    <a href="index.php?connect=directory" class="list-group-item active">All</a>
                </div>

            </div>--}}
            <div class="column col_table">
                <table class="table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Path</th>
                        <th>Mime Type</th>
                        <th>Url</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($files as $file)
                        <tr data-id="{{ $file->id }}">
                            <th>{{ $file->id }}</th>
                            <th><a href="{{ $file->path }}">{{ $file->path }}</a></th>
                            <th>{{ $file->mime_type }}</th>
                            <th>{{ $file->url }}</th>
                            <th><button class="delete" data-id="{{ $file->id }}">Delete</button></th>
                        </tr>
                    @endforeach
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="p"></div>
            </div>
            <div class="clear"><!--//--></div>
        </div></div>

    <div class="gadget">


@endsection
@section('footer')
    @parent
@stop