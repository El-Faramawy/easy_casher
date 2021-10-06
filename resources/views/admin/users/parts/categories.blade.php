<div class="card h-100" id="partNewDriver">
    <div class="card-header">
        <div class="card-title"> أقسام الاسرة  ({{$user->name}})</div>
    </div>
    <div class="card-body">
        <div class="row gutters">
            @if ($user->sub_categories)

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>اسم القسم</th>
                                <th>الصورة</th>
                                <th>وقت الإضافة</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->sub_categories as $row)
                            <tr>
                                <td>{{$row->title}}</td>
                                <td>
                                    <img width="60px" height="60px" src="{{get_file($row->image)}}">
                                </td>
                                <td>{{date('Y/m/d',strtotime($row->created_at))}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                @else
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="alert alert-danger">
                        لم يٌضف أقسام حتى الآن
                    </div>
                </div>
            @endif

            <br>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="text-right">

                    <a class='btn btn-info  pull-left '  href="{{route('users.index')}}"><span class='icon-arrow_back'></span> عودة </a>

                </div>
            </div>
        </div>

    </div>
</div>
