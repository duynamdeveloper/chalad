<ul>
@foreach($mobile as $mobile)

<li onClick="selectCountry('{{$mobile->phone}}');">{{$mobile->phone}}</li>

@endforeach
</ul>