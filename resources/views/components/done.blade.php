
@php($count = \App\Models\Observe::where('plan_id', $value)->get()->count() ?? 0)
@if( $count )
    <a style='display: block' href='{{route('observes.done',$value)}}'>{{$count}}</a>
@else
  {{$count}}
@endif