<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Update</title>
</head>

<body class="container my-3 mx-auto">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="row g-3 container mx-auto" action="{{url('users/save')."/".$data->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <label for="inputName" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputName" name="name" value="{{$data->name}}">
        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="text" class="form-control" id="inputEmail" name="email" value="{{$data->email}}">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</body>

</html>
