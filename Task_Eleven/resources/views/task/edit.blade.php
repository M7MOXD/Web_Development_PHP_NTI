<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Task</title>
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
    <form class="row g-3 container mx-auto" action="{{url('task/'.$data->id.'/update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="col-md-6">
            <label for="inputTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="inputTitle" name="title" value="{{$data->title}}">
        </div>
        <div class="col-md-6">
            <label for="inputContent" class="form-label">Content</label>
            <input type="text" class="form-control" id="inputContent" name="content" value="{{$data->content}}">
        </div>
        <div class="col-md-6">
            <label for="inputStart" class="form-label">Start</label>
            <input type="date" class="form-control" id="inputStart" name="start_date" value="{{date('Y-m-d', $data->start_date)}}">
        </div>
        <div class="col-md-6">
            <label for="inputEnd" class="form-label">End</label>
            <input type="date" class="form-control" id="inputEnd" name="end_date" value="{{date('Y-m-d', $data->end_date)}}">
        </div>
        <div class="col-md-12">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="image">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</body>

</html>
