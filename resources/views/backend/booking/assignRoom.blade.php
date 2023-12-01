<form action="" method="POST">
@csrf
    <table class="table">
        <tr>
            <th>Room Number</th>
            <th>Action</th>
        </tr>

        @foreach($roomNumbers as $roomNumber )
        <tr>
            <td>{{ $roomNumber['room_no'] }}</td>
            <td>
                <a href="{{ route('assign.room.store', [$booking->id, $roomNumber['id']]) }}" class="btn btn-primary text-white"><i class="lni lni-circle-plus"></i></a>
            </td>
        </tr>
        @endforeach
    </table>
</form>

