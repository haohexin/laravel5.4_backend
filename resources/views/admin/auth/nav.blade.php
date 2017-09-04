<div style="display: none">
    {{$nav = \App\Model\Navigation::with('secondLevel')->where ( 'level', '1' )->orderBy('rank','asc')->get()}}
</div>
@foreach($nav as $value)
    @if(Auth::guard('admin')->user()->can($value->permission))
        <li class="treeview">
            <a href="#">
                <i class="fa {{$value->icon}}"></i>
                <span>{{$value->name}}</span>
                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
            </a>
            <ul class="treeview-menu">
                @if($value->secondLevel)
                    @foreach($value->secondLevel as $value2)
                        @if(Auth::guard('admin')->user()->can($value2->permission))
                            <li tag="3-1">
                                <a href="{{url("$value2->url")}}">
                                    <i class="fa fa-circle-o"></i>{{$value2->name}}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </li>
    @endif
@endforeach