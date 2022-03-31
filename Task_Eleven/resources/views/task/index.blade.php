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
    <table class="table container mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Image</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
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
                    {{$item->title}}
                </td>
                <td>
                    {{$item->content}}
                </td>
                <td>
                    <img style='width: 50px; height: 50px;' src='{{url('/uploads/'.$item->image)}}'>
                </td>
                <td>
                    {{$item->start_date}}
                </td>
                <td>
                    {{$item->end_date}}
                </td>
                <td>
                    <a href="{{url('task/'.$item->id.'/edit')}}" class='btn btn-primary'>Edit</a>
                    <a href='{{url('task/'.$item->id.'/delete')}}' class='btn btn-danger'>Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
