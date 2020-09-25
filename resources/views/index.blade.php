@extends('layouts.default')

@section('content')


<h1>HOME</h1>
<ul>
    <li>見える化
        <ul>
            <li><a href="{{ route('mieru.ncs.index')}}">機械加工</a></li>
            <li><a href="">板金</a></li>
        </ul>
    </li>
</ul>

@endsection
