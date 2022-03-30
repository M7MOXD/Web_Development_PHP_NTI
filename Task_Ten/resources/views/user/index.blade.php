<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Users</title>
</head>

<body>
    {{'Welcome, '.auth()->user()->name}}
    <table class="table container mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Controls</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>
                    {{$item->id}}
                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->email}}
                </td>
                <td>
                    <a href="{{url('users/update/'.$item->id)}}" class='btn btn-primary'>Edit</a>
                    <a href='{{url('users/delete/'.$item->id)}}' class='btn btn-danger'>Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
