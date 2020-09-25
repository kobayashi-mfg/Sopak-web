@extends('layouts.nc_default')



@section('title','NC')

@section('content')
<section>
    <div class="container">
        <div class="row detail-table">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>社員番号</th>
                            <th>氏名</th>
                            <th>権限</th>
                        </tr>
                    </thead>
                    <tbody>
                        @can('system-only')
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td>{{ $user->employee_no }}</td>
                                    <td><a href="{{ route('users.edit', $user)}}">{{ $user->fullname }}</a></td>
                                    <td>{{ $privilege_msg[$user->privilege] }}</td>
                                </tr>
                            <?php endforeach; ?>
                        @elsecan('admin-higher')
                            <?php foreach($users as $user): ?>
                                <tr>
                                @if( ($user->id == $now_user_id) || ($user->privilege >= 5) )   <!--マネージャーと一般ユーザー表示-->
                                    <td>{{ $user->employee_no }}</td>
                                    <td><a href="{{ route('users.edit', $user)}}">{{ $user->fullname }}</a></td>
                                    <td>{{ $privilege_msg[$user->privilege] }}</td>
                                @else   <!--管理者非表示-->
                                    
                                @endif
                                </tr>
                            <?php endforeach; ?>
                        @elsecan('user-higher')
                            <?php foreach($users as $user): ?>
                                @if($user->id == $now_user_id)
                                    <td>{{ $user->employee_no }}</td>
                                    <td><a href="{{ route('users.edit', $user)}}">{{ $user->fullname }}</a></td>
                                    <td>{{ $privilege_msg[$user->privilege] }}</td>
                                @endif
                            <?php endforeach; ?>
                        @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
